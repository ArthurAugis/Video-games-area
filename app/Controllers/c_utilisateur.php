<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;
use App\Models\m_user;

class c_utilisateur extends BaseController
{
    /**
     * @return string|void
     * Méthode pour gérer la page utilisateur
     */
    public function index()
    {
        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            // vérifie si il y a eu un submit pour l'inscription
            if ($this->request->getPost('submit_form_inscription') !== null) {
                // création des règles/codes d'erreurs
                $rules = ['inscrire_mail' => 'required|valid_email'
                    , 'inscrire_login' => 'required|min_length[6]'
                    , 'inscrire_age' => 'required|greater_than_equal_to[0]'
                    ,'inscrire_mdp' => 'password'
                    ,'inscrire_confirme_mdp' => 'password|matches[inscrire_mdp]'
                    , 'inscrire_conditions' => 'required'];

                $errors = [
                    'inscrire_mail' => [
                        'required' => 'Le champ adresse mail est obligatoire.',
                        'valid_email' => "Ton mail n'est pas correct."
                    ],
                    'inscrire_login' => [
                        'required' => 'Le champ login est obligatoire.',
                        'min_length' => 'Ton pseudo doit faire au moins 6 caractères.'
                    ],
                    'inscrire_age' => [
                        'required' => 'Le champ âge est obligatoire.',
                        'greater_than_equal_to' => 'Ton âge doit au moins être de 0.'
                    ],
                    'inscrire_confirme_mdp' => [
                        'matches' => 'Ce champ doit être identique à ton mot de passe.'
                    ],
                    'inscrire_conditions' => [
                        'required' => 'Vous devez accepter les conditions.',
                    ],
                ];

                $validation->setRules($rules, $errors);

                if ($this->validate($rules, $errors)) {
                    $session = Services::session();

                    // stocke les différentes informations utilisateurs
                    $inscrire_mail = $this->request->getPost('inscrire_mail');
                    $inscrire_login = $this->request->getPost('inscrire_login');
                    $inscrire_age = $this->request->getPost('inscrire_age');
                    $inscrire_mdp = $this->request->getPost('inscrire_mdp');

                    // hash du mdp
                    $inscrire_hashPwd = password_hash($inscrire_mdp, PASSWORD_DEFAULT);

                    $model = new m_user();

                    // utilise la méthode createUser du modèle m_user
                    $insert = $model->createUser($inscrire_login, $inscrire_mail, $inscrire_age, $inscrire_hashPwd);

                    if ($insert === '-1') {
                        // indique que le pseudo est déjà utilisé
                        $info['titre'] = "Pseudo déjà utilisé !";
                    } elseif ($insert === '-2') {
                        // indique que le mail est déjà utilisé
                        $info['titre'] = "Mail déjà utilisé !";
                    } else {
                        // inscription réussie
                        $session->set('mail', $inscrire_mail);
                        $session->set('mdp', $inscrire_hashPwd);
                        $session->set('age', $inscrire_age);
                        $session->set('login', $inscrire_login);
                        $session->set('admin', 0);
                        $info['titre'] = '';
                    }
                } else {
                    // ne respecte pas les conditions
                    $info['titre'] = "Inscription impossible, Corrige ta saisie";
                }
                $info['validation'] = $this->validator;
                return view('v_header')
                    . view('utilisateur/v_utilisateur', $info)
                    . view('v_footer');
            }
        } else {
            return view('v_header')
                . view('utilisateur/v_utilisateur', ['validation' => $validation, 'titre' => ""])
                . view('v_footer');
        }
    }

    /**
     * @return string|void
     * Méthode pour gérer la page de connexion
     */
    public function connexion()
    {
        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            // vérifie si il y a eu un submit pour la connexion
            if ($this->request->getPost('submit_form_connexion') !== null) {
                // création des règles/codes d'erreurs
                $rules = ['connexion_mail' => 'required|valid_email'
                    , 'connexion_mdp' => 'password'];

                $errors = [
                    'connexion_mail' => [
                        'required' => 'Le champ adresse mail est obligatoire.',
                        'valid_email' => "Ton mail n'est pas correct."
                    ],
                ];

                $validation->setRules($rules, $errors);

                if ($this->validate($rules, $errors)) {
                    $session = Services::session();

                    // stocke le mail et le mdp
                    $connexion_mail = $this->request->getPost('connexion_mail');
                    $connexion_mdp = $this->request->getPost('connexion_mdp');

                    $model = new m_user();

                    // utilise la méthode loginUser du modèle m_user
                    $user = $model->loginUser($connexion_mail);

                    if ($user === -1) {
                        // il n'y a pas d'utilisateur avec ce mail
                        $info['titre'] = 'Email ou mot de passe invalide';
                        $info['validation'] = $this->validator;
                        return view('v_header') . view('utilisateur/v_connexion', $info) . view('v_footer');
                    } else {
                        // Vérifier le mot de passe
                        $verifPwd = password_verify($connexion_mdp, $user->mdp);
                        if ($verifPwd) {
                            // Mot de passe correct
                            $session->set('mail', $connexion_mail);
                            $session->set('mdp', $user->mdp);
                            $session->set('age', $user->age);
                            $session->set('login', $user->pseudo);
                            $session->set('admin', $user->admin);

                            header("Location: " . base_url() . 'public/utilisateur');
                            exit;
                        } else {
                            // Mot de passe incorrect
                            $info['titre'] = 'Email ou mot de passe invalide';
                            $info['validation'] = $this->validator;
                            return view('v_header') . view('utilisateur/v_connexion', $info) . view('v_footer');
                        }
                    }
                } else {
                    // Critères non respectés
                    $info['titre'] = "Connexion impossible, Corrige ta saisie";
                    $info['validation'] = $this->validator;
                    return view('v_header') . view('utilisateur/v_connexion', $info) . view('v_footer');
                }
            }
        } else {
            return view('v_header')
                . view('utilisateur/v_connexion', ['validation' => $validation, 'titre' => ""])
                . view('v_footer');
        }
    }

    /**
     * @return string
     * Méthode pour déconnecter l'utilisateur
     */
    public function deconnexion()
    {
        $session = Services::session();
        $validation = Services::validation();

        $rules = [];

        $errors = [];

        $validation->setRules($rules, $errors);

        // supprime les identifiants de l'utilisateur et donc fait la deconnexion
        $session->remove('mail');
        $session->remove('mdp');
        $session->remove('age');
        $session->remove('login');
        $session->remove('admin');
        $session->destroy();

        header("Location: " . base_url() . 'public/utilisateur');
        exit;
    }

    /**
     * @return string|void
     * Méthode pour changer gérer la page changer l'âge de l'utilisateur
     */
    public function changerage()
    {
        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            // vérifie si il y a eu un submit pour le changement d'âge
            if ($this->request->getPost('submit_form_changerage') !== null) {
                // création des règles/codes d'erreurs
                $rules = ['changerage_age' => 'required|greater_than_equal_to[0]'];

                $errors = [
                    'changerage_age' => [
                        'required' => 'Le champ âge est obligatoire.',
                        'greater_than_equal_to' => 'Ton âge doit au moins être de 0.'
                    ],
                ];

                $validation->setRules($rules, $errors);

                if ($this->validate($rules, $errors)) {
                    $session = Services::session();

                    // stocke l'âge
                    $changerage_age = $this->request->getPost('changerage_age');

                    $model = new m_user();

                    // utilise la méthode changerAge du modèle m_user
                    $agemodifie = $model->changerAge($changerage_age, $session->get('mail'));

                    if ($agemodifie === $changerage_age) {
                        // age modifie
                        $info['titre'] = '';
                        $info['validation'] = $this->validator;
                        $session->remove('age');
                        $session->set('age', $changerage_age);
                        return view('v_header') . view('utilisateur/v_utilisateur', $info) . view('v_footer');
                    } else {
                        // age non modifie
                        $info['titre'] = "Ton âge n'a pas pu être modifiée";
                        $info['validation'] = $this->validator;
                        return view('v_header') . view('utilisateur/v_changerage', $info) . view('v_footer');
                    }
                } else {
                    // Critères non respectés
                    $info['titre'] = "Changement de l'âge impossible, corrige ta saisie !";
                    $info['validation'] = $this->validator;
                    return view('v_header') . view('utilisateur/v_changerage', $info) . view('v_footer');
                }
            }
        } else {
            return view('v_header')
                . view('utilisateur/v_changerage', ['validation' => $validation, 'titre' => ""])
                . view('v_footer');
        }
    }

    /**
     * @return string|void
     * Méthode pour changer gérer la page changer le pseudo de l'utilisateur
     */
    public function changerpseudo()
    {
        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            // vérifie si il y a eu un submit pour le changement de pseudo
            if ($this->request->getPost('submit_form_changerpseudo') !== null) {
                // création des règles/codes d'erreurs
                $rules = ['changerpseudo_pseudo' => 'required|min_length[6]'];

                $errors = [
                    'changerpseudo_pseudo' => [
                        'required' => 'Le champ login est obligatoire.',
                        'min_length' => 'Ton pseudo doit faire au moins 6 caractères.'
                    ],
                ];

                $validation->setRules($rules, $errors);

                if ($this->validate($rules, $errors)) {
                    $session = Services::session();

                    // stocke le pseudo
                    $changerpseudo_pseudo = $this->request->getPost('changerpseudo_pseudo');

                    $model = new m_user();

                    // utilise la méthode changerAge du modèle m_user
                    $pseudomodifie = $model->changerPseudo($changerpseudo_pseudo, $session->get('mail'));

                    if ($pseudomodifie === '-1') {
                        // indique que le pseudo est déjà utilisé
                        $info['titre'] = "Pseudo déjà utilisé !";
                        $info['validation'] = $this->validator;
                        return view('v_header') . view('utilisateur/v_changerpseudo', $info) . view('v_footer');
                    } elseif ($pseudomodifie > 0) {
                        // pseudo modifie
                        $info['titre'] = '';
                        $info['validation'] = $this->validator;
                        $session->remove('login');
                        $session->set('login', $changerpseudo_pseudo);
                        return view('v_header') . view('utilisateur/v_utilisateur', $info) . view('v_footer');
                    } else {
                        // pseudo non modifie
                        $info['titre'] = "Ton pseudo n'a pas pu être modifiée";
                        $info['validation'] = $this->validator;
                        return view('v_header') . view('utilisateur/v_changerpseudo', $info) . view('v_footer');
                    }
                } else {
                    // Critères non respectés
                    $info['titre'] = "Changement de pseudo impossible, corrige ta saisie !";
                    $info['validation'] = $this->validator;
                    return view('v_header') . view('utilisateur/v_changerpseudo', $info) . view('v_footer');
                }
            }
        } else {
            return view('v_header')
                . view('utilisateur/v_changerpseudo', ['validation' => $validation, 'titre' => ""])
                . view('v_footer');
        }
    }

    /**
     * @return string|void
     * Méthode pour changer gérer la page changer le mail de l'utilisateur
     */
    public function changermail()
    {
        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            // vérifie si il y a eu un submit pour le changement de pseudo
            if ($this->request->getPost('submit_form_changermail') !== null) {
                // création des règles/codes d'erreurs
                $rules = ['changermail_mail' => 'required|valid_email'];

                $errors = [
                    'changermail_mail' => [
                        'required' => 'Le champ adresse mail est obligatoire.',
                        'valid_email' => "Ton mail n'est pas correct."
                    ],
                ];

                $validation->setRules($rules, $errors);

                if ($this->validate($rules, $errors)) {
                    $session = Services::session();

                    // stocke le mail
                    $changermail_mail = $this->request->getPost('changermail_mail');

                    $model = new m_user();

                    // utilise la méthode changerMail du modèle m_user
                    $mailmodifie = $model->changerMail($changermail_mail, $session->get('mail'));

                    if ($mailmodifie == -1) {
                        // indique que le mail est déjà utilisé
                        $info['titre'] = "Mail déjà utilisé !";
                        $info['validation'] = $this->validator;
                        return view('v_header') . view('utilisateur/v_changermail', $info) . view('v_footer');
                    } else {
                        // mail modifie
                        $info['titre'] = '';
                        $info['validation'] = $this->validator;
                        $session->remove('mail');
                        $session->set('mail', $changermail_mail);
                        return view('v_header') . view('utilisateur/v_utilisateur', $info) . view('v_footer');
                    }
                } else {
                    // Critères non respectés
                    $info['titre'] = "Changement de mail impossible, corrige ta saisie !";
                    $info['validation'] = $this->validator;
                    return view('v_header') . view('utilisateur/v_changermail', $info) . view('v_footer');
                }
            }
        } else {
            return view('v_header')
                . view('utilisateur/v_changermail', ['validation' => $validation, 'titre' => ""])
                . view('v_footer');
        }
    }

    /**
     * @return string|void
     * Méthode pour changer gérer la page changer le mot de passe de l'utilisateur
     */
    public function changerMdp()
    {
        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            // vérifie si il y a eu un submit pour le changement du mdp
            if ($this->request->getPost('submit_form_changermdp') !== null) {
                // création des règles/codes d'erreurs
                $rules = [
                    'changermdp_mdp' => 'password'
                    ,'changermdp_confirmmdp' => 'password|matches[changermdp_mdp]'];

                $errors = [
                    'changermdp_confirmmdp' => [
                        'matches' => 'Ce champ doit être identique à ton mot de passe.'
                    ]
                ];

                $validation->setRules($rules, $errors);

                if ($this->validate($rules, $errors)) {
                    $session = Services::session();

                    // stocke le mdp
                    $changermdp_mdp = $this->request->getPost('changermdp_mdp');
                    $hash_changermdp_mdp = password_hash($changermdp_mdp, PASSWORD_DEFAULT);
                    $model = new m_user();

                    // utilise la méthode changerMdp du modèle m_user
                    $mdpmodifie = $model->changerMdp($hash_changermdp_mdp, $session->get('mail'));

                    if ($mdpmodifie === $hash_changermdp_mdp) {
                        // mdp modifie
                        $info['titre'] = '';
                        $info['validation'] = $this->validator;
                        $session->remove('mdp');
                        $session->set('mdp', $hash_changermdp_mdp);
                        return view('v_header') . view('utilisateur/v_utilisateur', $info) . view('v_footer');
                    } else {
                        // mdp non modifie
                        $info['titre'] = "Ton mot de passe n'a pas pu être modifiée";
                        $info['validation'] = $this->validator;
                        return view('v_header') . view('utilisateur/v_changermdp', $info) . view('v_footer');
                    }
                } else {
                    // Critères non respectés
                    $info['titre'] = "Changement du mot de passe impossible, corrige ta saisie !";
                    $info['validation'] = $this->validator;
                    return view('v_header') . view('utilisateur/v_changermdp', $info) . view('v_footer');
                }
            }
        } else {
            return view('v_header')
                . view('utilisateur/v_changermdp', ['validation' => $validation, 'titre' => ""])
                . view('v_footer');
        }
    }
}

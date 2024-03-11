<?php

namespace App\Controllers;

use App\Models\m_admin;
use App\Models\m_quiz;
use App\Models\m_tournois;
use App\Models\m_vote;
use CodeIgniter\Config\Services;

class c_admin extends BaseController
{
    public function ajoutAdmin(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->ajoutAdmin($this->request->getPost('nonAdmin'));
            $data['titre'] = 'Administrateur ajouté avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['nonAdminList'] = $model->getNonAdminList();

        return view('v_header') . view('admin/v_ajoutAdmin', $data) . view('v_footer');
    }

    public function supprAdmin(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprAdmin($this->request->getPost('admin'));
            $data['titre'] = 'Administrateur supprimé avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['adminList'] = $model->getAdminList();

        return view('v_header') . view('admin/v_supprAdmin', $data) . view('v_footer');
    }

    public function ajoutQuestion(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            $rules = ['question' => 'required|'];

            $errors = [
                'question' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 200 caractères.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $model->ajoutQuestion($this->request->getPost('question'));
                $data['titre'] = 'Question ajoutée avec succès !';
                $data['validation'] = $this->validator;
            } else {
                // Critères non respectés
                $data['titre'] = "Ajout de la question impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }
        return view('v_header') . view('admin/v_ajoutQuestion', $data) . view('v_footer');
    }

    public function supprQuestion(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprQuestion($this->request->getPost('question'));
            $data['titre'] = 'Question supprimée avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['questionList'] = $model->getQuestionsList();

        return view('v_header') . view('admin/v_supprQuestion', $data) . view('v_footer');
    }

    public function ajoutReponse(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            $rules = ['reponse' => 'required|max_length[300]'];

            $errors = [
                'reponse' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 300 caractères.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $model->ajoutReponse($this->request->getPost('reponse'));
                $data['titre'] = 'Réponse ajoutée avec succès !';
                $data['validation'] = $this->validator;
            } else {
                // Critères non respectés
                $data['titre'] = "Ajout de la réponse impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }
        return view('v_header') . view('admin/v_ajoutReponse', $data) . view('v_footer');
    }

    public function supprReponse(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprReponse($this->request->getPost('reponse'));
            $data['titre'] = 'Réponse supprimée avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['reponseList'] = $model->getReponsesList();

        return view('v_header') . view('admin/v_supprReponse', $data) . view('v_footer');
    }

    public function ajoutPlateforme(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        if ($this->request->getMethod() === 'post') {
            $rules = ['plateforme' => 'required|max_length[50]'];

            $errors = [
                'plateforme' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 50 caractères.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $model->ajoutPlateforme($this->request->getPost('plateforme'));
                $data['titre'] = 'Plateforme ajoutée avec succès !';
                $data['validation'] = $this->validator;
            } else {
                // Critères non respectés
                $data['titre'] = "Ajout de la plateforme impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }
        return view('v_header') . view('admin/v_ajoutPlateforme', $data) . view('v_footer');
    }

    public function supprPlateforme(): string
    {

        $model = new m_admin();
        $modelVote = new m_vote();

        if ($this->request->getMethod() === 'post') {
            $model->supprPlateforme($this->request->getPost('plateforme'));
            $data['titre'] = 'Plateforme supprimée avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['plateformeList'] = $modelVote->getPlateformes();

        return view('v_header') . view('admin/v_supprPlateforme', $data) . view('v_footer');
    }

    public function ajoutJeu(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            $rules = ['nom' => 'required|max_length[100]',
                'description' => 'required|max_length[1000]',
                'url_image' => 'required|max_length[200]|valid_url',
                'pegi' => 'required|greater_than_equal_to[0]'];

            $errors = [
                'nom' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 100 caractères.'
                ],
                'description' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 1000 caractères.'
                ],
                'url_image' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 200 caractères.',
                    'valid_url' => 'Ce champ doit être une url.'
                ],
                'pegi' => [
                    'required' => 'Ce champ est obligatoire.',
                    'greater_than_equal_to' => 'Ce champ doit être supérieur ou égal à 0.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $model->ajoutJeu($this->request->getPost('nom'), $this->request->getPost('description'), $this->request->getPost('url_image'), $this->request->getPost('pegi'));
                $data['titre'] = 'Jeu ajouté avec succès !';
                $data['validation'] = $this->validator;
            } else {
                // Critères non respectés
                $data['titre'] = "Ajout du jeu impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }
        return view('v_header') . view('admin/v_ajoutJeu', $data) . view('v_footer');
    }

    public function supprJeu(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprJeu($this->request->getPost('jeu'));
            $data['titre'] = 'Jeu supprimé avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['jeuxList'] = $model->getJeuxList();

        return view('v_header') . view('admin/v_supprJeu', $data) . view('v_footer');
    }

    public function ajoutCategorie(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        // vérifie si il y a eu une méthode post
        if ($this->request->getMethod() === 'post') {
            $rules = ['categorie' => 'required|max_length[50]'];

            $errors = [
                'categorie' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire max 50 caractères.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $model->ajoutCategorie($this->request->getPost('categorie'));
                $data['titre'] = 'Catégorie ajoutée avec succès !';
                $data['validation'] = $this->validator;
            } else {
                $data['titre'] = "Ajout de la catégorie impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }
        return view('v_header') . view('admin/v_ajoutCategorie', $data) . view('v_footer');
    }

    public function supprCategorie(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprCategorie($this->request->getPost('categorie'));
            $data['titre'] = 'Catégorie supprimée avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['categoriesList'] = $model->getCategories();

        return view('v_header') . view('admin/v_supprCategorie', $data) . view('v_footer');
    }

    public function ajoutReponseAQuestion(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $bonnereponse = 0;
            if($this->request->getPost('bonne'))
            {
                $bonnereponse = 1;
            }
            $model->ajout_attribuer(
                $this->request->getPost('question'),
                $this->request->getPost('reponse'),
                $bonnereponse
            );
            $data['titre'] = 'Réponse ajoutée à la question !';
        } else {
            $data['titre'] = '';
        }

        $data['questionsList'] = $model->getQuestionsList();
        $data['reponsesList'] = $model->getReponsesList();

        return view('v_header') . view('admin/v_ajoutReponseAQuestion', $data) . view('v_footer');
    }

    public function ajoutCategorieAJeu(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->ajout_categoriser(
                $this->request->getPost('jeu'),
                $this->request->getPost('categorie')
            );
            $data['titre'] = 'Catégorie ajoutée au jeu !';
        } else {
            $data['titre'] = '';
        }

        $data['categoriesList'] = $model->getCategories();
        $data['jeuxList'] = $model->getJeuxList();

        return view('v_header') . view('admin/v_ajoutCategorieAJeu', $data) . view('v_footer');
    }

    public function ajoutJeuAPlateforme(): string
    {

        $model = new m_admin();
        $modelVote = new m_vote();


        if ($this->request->getMethod() === 'post') {
            $model->ajoutJeuAPlateforme(
                $this->request->getPost('jeu'),
                $this->request->getPost('plateforme')
            );
            $data['titre'] = 'Jeu ajouté à la plateforme !';
        } else {
            $data['titre'] = '';
        }

        $data['plateformeList'] = $modelVote->getPlateformes();
        $data['jeuxList'] = $model->getJeuxList();

        return view('v_header') . view('admin/v_ajoutJeuAPlateforme', $data) . view('v_footer');
    }

    public function ajoutTournoi(): string
    {

        $model = new m_admin();


        if ($this->request->getMethod() === 'post') {
            $model->ajoutTournoi(
                $this->request->getPost('jeu'),
            );
            $data['titre'] = 'Tournoi ajouté à la plateforme !';
        } else {
            $data['titre'] = '';
        }

        $data['nonTournoisList'] = $model->getNonTournoisList();

        return view('v_header') . view('admin/v_ajoutTournoi', $data) . view('v_footer');
    }

    public function ajoutSession(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        if ($this->request->getMethod() === 'post') {
            $rules = ['date' => 'required',
                'heure' => 'required',
                'places' => 'required|greater_than_equal_to[0]'];

            $errors = [
                'date' => [
                    'required' => 'Ce champ est obligatoire.',
                ],
                'heure' => [
                    'required' => 'Ce champ est obligatoire.',
                ],
                'places' => [
                    'required' => 'Ce champ est obligatoire.',
                    'greater_than_equal_to' => 'Ce champ doit être égal ou supérieur à 0.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $date_sql = date('Y-m-d', strtotime($this->request->getPost('date')));
                $heure_sql = date('H:i:s', strtotime($this->request->getPost('heure')));
                $model->ajoutSession($this->request->getPost('tournoi'), $date_sql, $heure_sql, $this->request->getPost('places'));
                $data['titre'] = 'Session de tournoi ajoutée avec succès !';
                $data['validation'] = $this->validator;
            } else {
                // Critères non respectés
                $data['titre'] = "Ajout de la session de tournoi impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }

        $data['tournoisList'] = $model->getTournoisList();

        return view('v_header') . view('admin/v_ajoutSession', $data) . view('v_footer');
    }

    public function ajoutRecompense(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'place' => 'required|greater_than_equal_to[1]',
                'recompense' => 'required|max_length[1000]'
            ];

            $errors = [
                'place' => [
                    'required' => 'Ce champ est obligatoire.',
                    'greater_than_equal_to' => 'Ce champ doit être égal ou supérieur à 1.'
                ],
                'recompense' => [
                    'required' => 'Ce champ est obligatoire.',
                    'max_length' => 'Ce champ doit faire un maximum de 1000 caractères'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                $model->ajoutRecompense($this->request->getPost('session'), $this->request->getPost('place'), $this->request->getPost('recompense'));
                $data['titre'] = 'Récompense ajoutée avec succès !';
                $data['validation'] = $this->validator;
            } else {
                $data['titre'] = "Ajout de la récompense impossible !";
                $data['validation'] = $this->validator;
            }
        } else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }

        $data['sessionsList'] = $model->getAllSessions();

            return view('v_header') . view('admin/v_ajoutRecompense', $data) . view('v_footer');
    }

    public function supprTournoi(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprTournoi($this->request->getPost('tournoi'));
            $data['titre'] = 'Tournoi supprimé avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['tournoisList'] = $model->getTournoisList();

        return view('v_header') . view('admin/v_supprTournoi', $data) . view('v_footer');
    }

    public function supprReponseAQuestion(): string
    {

        $model = new m_admin();
        $modelQuiz = new m_quiz();

        if ($this->request->getMethod() === 'post') {
            $model->supprReponseAQuestion($this->request->getPost('reponse'));
            $data['titre'] = 'Réponse correctement supprimée à la question !';
        } else {
            $data['titre'] = '';
        }

        $data['quiz'] = $modelQuiz->getQuiz();

        return view('v_header') . view('admin/v_supprReponseAQuestion', $data) . view('v_footer');
    }

    public function supprRecompense(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprRecompense($this->request->getPost('recompense'));
            $data['titre'] = 'Récompense supprimée avec succès !';
        } else {
            $data['titre'] = '';
        }

        $data['recompensesList'] = $model->getRecompensesList();

        return view('v_header') . view('admin/v_supprRecompense', $data) . view('v_footer');
    }

    public function supprCategorieAJeu(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprCategoriser($this->request->getPost('categorie'));
            $data['titre'] = 'Catégorie supprimée du jeu !';
        } else {
            $data['titre'] = '';
        }

        $data['categoriesJeuxList'] = $model->getCategoriesJeux();

        return view('v_header') . view('admin/v_supprCategorieAJeu', $data) . view('v_footer');
    }

    public function supprPlateformeAJeu(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprPlateformeJeu($this->request->getPost('plateforme'));
            $data['titre'] = 'Plateforme supprimée du jeu !';
        } else {
            $data['titre'] = '';
        }

        $data['plateformeJeuxList'] = $model->getPlateformesJeux();

        return view('v_header') . view('admin/v_supprPlateformeAJeu', $data) . view('v_footer');
    }

    public function supprSession(): string
    {

        $model = new m_admin();

        if ($this->request->getMethod() === 'post') {
            $model->supprSession($this->request->getPost('session'));
            $data['titre'] = 'Session supprimée du jeu !';
        } else {
            $data['titre'] = '';
        }

        $data['sessionsList'] = $model->getAllSessions();

        return view('v_header') . view('admin/v_supprSession', $data) . view('v_footer');
    }

    public function modifDatesVote(): string
    {

        $model = new m_admin();

        $validation = Services::validation();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'date_debut' => 'required',
                'date_fin' => 'required'
            ];

            $errors = [
                'date_debut' => [
                    'required' => 'Ce champ est obligatoire.'
                ],
                'date_fin' => [
                    'required' => 'Ce champ est obligatoire.'
                ],
            ];

            $validation->setRules($rules, $errors);

            if ($this->validate($rules, $errors)) {
                // Convertir les dates au format MySQL datetime
                $date_debut = date('Y-m-d H:i:s', strtotime($this->request->getPost('date_debut')));
                $date_fin = date('Y-m-d H:i:s', strtotime($this->request->getPost('date_fin')));

                $model->modifDatesVote($date_debut, $date_fin);

                $data['titre'] = 'Dates modifiées avec succès !';
                $data['validation'] = $this->validator;
            } else {
                $data['titre'] = "Modification des dates impossible !";
                $data['validation'] = $this->validator;
            }
        }
        else {
            $data['titre'] = '';
            $data['validation'] = $this->validator;
        }

        return view('v_header') . view('admin/v_modifDatesVote', $data) . view('v_footer');
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_accueil;
use CodeIgniter\Config\Services;

class c_accueil extends BaseController
{
    public function index(): string
    {
        // Initialisation du service de validation
        $validation = Services::validation();

        // Vérification si la méthode HTTP utilisée est POST
        if ($this->request->getPost('submit_form_ajout_avis') !== null) {
            // Définition des règles de validation
            $rules = [
                'ajout_avis_commentaire' => 'required',
                'ajout_avis_note' => 'required|greater_than_equal_to[0]|less_than_equal_to[5]',
            ];

            // Définition des messages d'erreur associés aux règles de validation
            $errors = [
                'ajout_avis_commentaire' => [
                    'required' => 'Le champ commentaire est obligatoire.',
                ],
                'ajout_avis_note' => [
                    'required' => 'Le champ note est obligatoire.',
                    'greater_than_equal_to' => 'La note doit être égale ou supérieure à 0.',
                    'less_than_equal_to' => 'La note doit être égale ou inférieure à 5.',
                ],
            ];

            // Définition des règles et messages d'erreur pour la validation
            $validation->setRules($rules, $errors);

            // Validation des données soumises
            if ($this->validate($rules, $errors)) {
                // Récupération des services nécessaires
                $session = Services::session();
                $modelAccueil = new m_accueil();

                // Récupération des données soumises
                $ajout_avis_tournois = $this->request->getPost('ajout_avis_tournois');
                $ajout_avis_note = $this->request->getPost('ajout_avis_note');
                $ajout_avis_commentaire = $this->request->getPost('ajout_avis_commentaire');

                // Vérification de la connexion de l'utilisateur
                if (session()->get('login')) {
                    // Récupération des participations
                    $data['participe'] = $modelAccueil->getSessionsParticipe(session()->get('login'));
                    // Ajout d'un avis
                    $modelAccueil->ajout_avis(session()->get('login'), $ajout_avis_tournois, $ajout_avis_note, $ajout_avis_commentaire);
                }

                // Récupération des commentaires
                $data['commentaires'] = $modelAccueil->getCommentaires();
                $data['commentaires'] = esc($data['commentaires']);

                // Retourne la vue avec les données et la validation
                return view('v_header') . view('v_accueil', $data) . view('v_footer');
            } else {
                // Retourne la vue avec les données et la validation en cas d'erreur de validation
                $data['validation'] = $this->validator;
                $modelAccueil = new m_accueil();

                // Récupération de tous les commentaires
                $data['commentaires'] = $modelAccueil->getCommentaires();
                $data['commentaires'] = esc($data['commentaires']);

                // Vérification de la connexion de l'utilisateur
                if (session()->get('login')) {
                    // Récupération de toutes les participations
                    $data['participe'] = $modelAccueil->getSessionsParticipe(session()->get('login'));
                }

                // Retourne la vue avec les données et la validation
                return view('v_header') . view('v_accueil', $data) . view('v_footer');
            }
        } else if ($this->request->getPost('submit_form_suppr_commentaire') !== null) {
            // Récupération des services nécessaires
            $session = Services::session();
            $modelAccueil = new m_accueil();

            $modelAccueil->suppr_avis($this->request->getPost('suppr_commentaire'));

            // Récupération des commentaires
            $data['commentaires'] = $modelAccueil->getCommentaires();
            $data['commentaires'] = esc($data['commentaires']);

            // Vérification de la connexion de l'utilisateur
            if (session()->get('login')) {
                // Récupération de toutes les participations
                $data['participe'] = $modelAccueil->getSessionsParticipe(session()->get('login'));
            }

            // Retourne la vue avec les données et la validation
            return view('v_header') . view('v_accueil', $data) . view('v_footer');
        } else {
            // Retourne la vue avec les données et la validation en cas d'erreur de validation
            $data['validation'] = $this->validator;
            $modelAccueil = new m_accueil();

            // Récupération de tous les commentaires
            $data['commentaires'] = $modelAccueil->getCommentaires();
            $data['commentaires'] = esc($data['commentaires']);

            // Vérification de la connexion de l'utilisateur
            if (session()->get('login')) {
                // Récupération de toutes les participations
                $data['participe'] = $modelAccueil->getSessionsParticipe(session()->get('login'));
            }

            // Retourne la vue avec les données et la validation
            return view('v_header') . view('v_accueil', $data) . view('v_footer');
        }
    }
}

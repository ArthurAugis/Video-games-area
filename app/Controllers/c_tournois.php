<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_tournois;
use App\Models\m_vote;

class c_tournois extends BaseController
{
    public function index(): string
    {
        // vérifie si il y a eu un post
        if ($this->request->getMethod() === 'post') {
            $modelVote = new m_vote();
            $modelTournois = new m_tournois();

            // vérifie si il y a une connexion
            if (session()->get('login')) {
                // ajoute un vote à l'utilisateur pour le jeu choisi
                if($this->request->getPost('sessions')) {
                    $modelTournois->addInscription(session()->get('login'), $this->request->getPost('sessions'));
                }

                // récupére toutes les inscriptions aux tournois de l'utilisateur
                $data['inscriptions'] = $modelTournois->getInscriptions(session()->get('login'));

                // si oui récupére tout les votes de l'utilisateur
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            // récupére toutes les informations (date de vote, la plateforme par défaut, les résultats du vote actuels,
            // les jeux, le titre, les plateformes)
            $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
            $data['tournois'] = $modelTournois->getTournois($data['platform']);
            $data['titre'] = 'Inscription bien effectué';
            $data['plateformes'] = $modelVote->getPlateformes();

            // retourne un ensemble de view
            return view('v_header') . view('v_tournois', $data) . view('v_footer');
        } else {
            $modelVote = new m_vote();
            $modelTournois = new m_tournois();

            if(session()->get('login')){
                // récupére toutes les inscriptions aux tournois de l'utilisateur
                $data['inscriptions'] = $modelTournois->getInscriptions(session()->get('login'));
            }

            // récupére toutes les informations (date de vote, la plateforme par défaut, les résultats du vote actuels,
            // les jeux, le titre, les plateformes)
            $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
            $data['tournois'] = $modelTournois->getTournois($data['platform']);
            $data['titre'] = '';
            $data['plateformes'] = $modelVote->getPlateformes();

            // retourne un ensemble de view
            return view('v_header') . view('v_tournois', $data) . view('v_footer');
        }
    }

    public function InscriptionTournois($plateforme): string
    {
        // vérifie si il y a eu un post
        if ($this->request->getMethod() === 'post') {
            $modelVote = new m_vote();
            $modelTournois = new m_tournois();

            // vérifie si il y a une connexion
            if (session()->get('login')) {
                // ajoute un vote à l'utilisateur pour le jeu choisi
                $modelTournois->addInscription(session()->get('login'), $this->request->getPost('sessions'));

                // récupére toutes les inscriptions aux tournois de l'utilisateur
                $data['inscriptions'] = $modelTournois->getInscriptions(session()->get('login'));

                // si oui récupére tout les votes de l'utilisateur
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            // récupére toutes les informations (date de vote, la plateforme par défaut, les résultats du vote actuels,
            // les jeux, le titre, les plateformes)
            $data['platform'] = $plateforme;
            $data['tournois'] = $modelTournois->getTournois($data['platform']);
            $data['titre'] = 'Inscription bien effectué';
            $data['plateformes'] = $modelVote->getPlateformes();

            // retourne un ensemble de view
            return view('v_header') . view('v_tournois', $data) . view('v_footer');
        } else {
            $modelVote = new m_vote();
            $modelTournois = new m_tournois();

            if(session()->get('login')){
                // récupére toutes les inscriptions aux tournois de l'utilisateur
                $data['inscriptions'] = $modelTournois->getInscriptions(session()->get('login'));
            }

            // récupére toutes les informations (date de vote, la plateforme par défaut, les résultats du vote actuels,
            // les jeux, le titre, les plateformes)
            $data['platform'] = $plateforme;
            $data['tournois'] = $modelTournois->getTournois($data['platform']);
            $data['titre'] = '';
            $data['plateformes'] = $modelVote->getPlateformes();

            // retourne un ensemble de view
            return view('v_header') . view('v_tournois', $data) . view('v_footer');
        }
    }

    public function getSessionsTournoi()
    {
        // Récupération des données POST
        $postData = $this->request->getPost();

        // Récupération des valeurs 'jeu' et 'plateforme' du formulaire
        $jeu = isset($postData['jeu']) ? $postData['jeu'] : null;
        $plateforme = isset($postData['plateforme']) ? $postData['plateforme'] : null;

        // Vérification si les valeurs 'jeu' et 'plateforme' sont présentes
        if ($jeu !== null && $plateforme !== null) {
            // Instanciation du modèle Tournois
            $modelTournois = new m_tournois();

            // Récupération des sessions de tournoi pour le jeu et la plateforme spécifiés
            $reponse = $modelTournois->getSessionsTournoi($jeu, $plateforme);

            // Retourne une réponse JSON avec succès et les données récupérées
            return $this->response->setJSON([
                'success' => true,
                'message' => 'La requête AJAX a été traitée avec succès.',
                'data' => $reponse
            ]);
        } else {
            // Retourne une réponse JSON indiquant que les données requises sont manquantes
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Les données requises sont manquantes.'
            ]);
        }
    }
}
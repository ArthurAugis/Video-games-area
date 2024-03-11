<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_recompenses;
use App\Models\m_tournois;
use App\Models\m_vote;

class c_prix extends BaseController
{
    public function index(): string
    {
        $modelVote = new m_vote();
        $modelTournois = new m_tournois();

        // récupére toutes les informations (la plateforme par défaut,
        // les jeux, le titre, les plateformes)
        $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
        $data['tournois'] = $modelTournois->getTournois($data['platform']);
        $data['plateformes'] = $modelVote->getPlateformes();

        return view('v_header') . view('v_prix', $data) . view('v_footer');
    }

    public function prixPlateforme($plateforme): string
    {
        $modelVote = new m_vote();
        $modelTournois = new m_tournois();

        // récupére toutes les informations (les jeux, le titre, les plateformes)
        $data['platform'] = $plateforme;
        $data['tournois'] = $modelTournois->getTournois($data['platform']);
        $data['plateformes'] = $modelVote->getPlateformes();

        return view('v_header') . view('v_prix', $data) . view('v_footer');
    }

    public function getRecompensesTournoi()
    {
        // Récupération des données POST
        $postData = $this->request->getPost();

        // Vérification de la présence de la clé 'session' dans les données POST
        $tournoi_session = isset($postData['session']) ? $postData['session'] : null;

        // Traitement si la clé 'session' est présente
        if ($tournoi_session !== null) {
            // Instanciation du modèle de récompenses
            $modelRecompenses = new m_recompenses();

            // Récupération des récompenses pour la session de tournoi spécifiée
            $reponse = $modelRecompenses->getRecompenses($tournoi_session);

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

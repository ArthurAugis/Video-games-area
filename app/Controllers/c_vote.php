<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_vote;

class c_vote extends BaseController
{
    /**
     * @return string
     * Méthode pour gêrer la page vote sans paramètre
     */
    public function index(): string
    {
        // vérifie si il y a eu un post
        if ($this->request->getMethod() === 'post') {
            $modelVote = new m_vote();

            // vérifie si il y a une connexion
            if (session()->get('login')) {
                // ajoute un vote à l'utilisateur pour le jeu choisi
                $modelVote->addVote(session()->get('login'), $this->request->getPost('jeu-input'));

                // si oui récupére tout les votes de l'utilisateur
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            // récupére toutes les informations (date de vote, la plateforme par défaut, les résultats du vote actuels,
            // les jeux, le titre, les plateformes)
            $data['datesVote'] = $modelVote->getDatesVote();
            $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
            $data['resultats'] = $modelVote->getResultats($data['platform']);
            $data['vote'] = $modelVote->getJeuxVote($data['platform']);
            $data['titre'] = 'Vote bien effectué';
            $data['plateformes'] = $modelVote->getPlateformes();

            // retourne un ensemble de view
            return view('v_header') . view('v_vote', $data) . view('v_footer');
        } else {
            $modelVote = new m_vote();

            // vérifie si il y a une connexion
            if (session()->get('login')) {
                // si oui récupére tout les votes de l'utilisateur
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            // récupére toutes les informations (date de vote, la plateforme par défaut, les résultats du vote actuels,
            // les jeux, le titre, les plateformes)
            $data['datesVote'] = $modelVote->getDatesVote();
            $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
            $data['resultats'] = $modelVote->getResultats($data['platform']);
            $data['vote'] = $modelVote->getJeuxVote($data['platform']);
            $data['titre'] = '';
            $data['plateformes'] = $modelVote->getPlateformes();

            // retourne un ensemble de view
            return view('v_header') . view('v_vote', $data) . view('v_footer');
        }
    }

    /**
     * @param $plateforme
     * @return string|void
     * Méthode pour gêrer la page vote avec le paramètre du nom de la plateforme
     */
    public function VoteJeux($plateforme)
    {
        // vérifie si il y a eu un post
        if ($this->request->getMethod() === 'post') {
            $modelVote = new m_vote();

            // vérifie si il y a une connexion
            if (session()->get('login')) {
                // ajoute un vote à l'utilisateur pour le jeu choisi
                $modelVote->addVote(session()->get('login'), $this->request->getPost('jeu-input'));

                // si oui récupére tout les votes de l'utilisateur
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            // vérifie si la plateforme existe dans la base de données
            $platformData = $modelVote->getPlatform($plateforme);
            if (!empty($platformData)) {
                // récupére toutes les informations (date de vote, la plateforme par défaut
                //, les résultats du vote actuels, les jeux, le titre, les plateformes)
                $data['datesVote'] = $modelVote->getDatesVote();
                $data['platform'] = $platformData[0]->nom;
                $data['resultats'] = $modelVote->getResultats($plateforme);
                $data['vote'] = $modelVote->getJeuxVote($plateforme);
                $data['titre'] = 'Vote bien effectué';
                $data['plateformes'] = $modelVote->getPlateformes();

                // retourne un ensemble de view
                return view('v_header') . view('v_vote', $data) . view('v_footer');
            } else {
                // si la plateforme n'existe pas l'utilisateur est renvoyé à la page de vote par défaut.
                header("Location: " . base_url() . 'vote');
                exit;
            }
        } else {
            $modelVote = new m_vote();

            // vérifie si il y a une connexion
            if (session()->get('login')) {
                // si oui récupére tout les votes de l'utilisateur
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            // vérifie si la plateforme existe dans la base de données
            $platformData = $modelVote->getPlatform($plateforme);
            if (!empty($platformData)) {
                // récupére toutes les informations (date de vote, la plateforme par défaut,
                // les résultats du vote actuels, les jeux, le titre, les plateformes)
                $data['datesVote'] = $modelVote->getDatesVote();
                $data['platform'] = $platformData[0]->nom;
                $data['vote'] = $modelVote->getJeuxVote($plateforme);
                $data['resultats'] = $modelVote->getResultats($plateforme);
                $data['titre'] = '';
                $data['plateformes'] = $modelVote->getPlateformes();

                // retourne un ensemble de view
                return view('v_header') . view('v_vote', $data) . view('v_footer');
            } else {
                // si la plateforme n'existe pas l'utilisateur est renvoyé à la page de vote par défaut.
                header("Location: " . base_url() . 'vote');
                exit;
            }
        }
    }
}

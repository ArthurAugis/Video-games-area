<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_quiz;

class c_quiz extends BaseController
{
    public function index(): string
    {
        $modelQuiz = new m_quiz();

        // utilise la méthode getQuiz du model m_quiz
        $data['quiz'] = $modelQuiz->getQuiz();

        return view('v_header') . view('v_quiz', $data) . view('v_footer');
    }

    public function scoreboardQuiz(): string
    {
        // Instanciation du modèle Quiz
        $modelQuiz = new m_quiz();

        // Vérification si la méthode HTTP utilisée est POST
        if ($this->request->getMethod() === 'post') {
            // Vérification de la connexion de l'utilisateur et de la présence du score dans les données POST
            if (session()->get('login') && $this->request->getPost('score-input')) {
                // Ajout du résultat du quiz pour l'utilisateur connecté
                $modelQuiz->ajoutResultQuiz(session()->get('login'), $this->request->getPost('score-input'));
            }
        }

        // Récupération des meilleurs scores
        $data['top10'] = $modelQuiz->getTop10();

        // Retourne la vue avec les données des meilleurs scores
        return view('v_header') . view('v_scoreboard', $data) . view('v_footer');

    }
}
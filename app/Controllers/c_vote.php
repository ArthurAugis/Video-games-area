<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_vote;

class c_vote extends BaseController
{
    public function index(): string
    {
        if ($this->request->getMethod() === 'post') {
            $modelVote = new m_vote();

            if(session()->get('login'))
            {
                $modelVote->addVote(session()->get('login'), $this->request->getPost('jeu-input'));
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
            $data['vote'] = $modelVote->getJeuxVote($data['platform']);
            $data['titre'] = 'Vote bien effectué';
            $data['plateformes'] = $modelVote->getPlateformes();

            return view('v_header') . view('v_vote', $data) . view('v_footer');
        }
        else
        {
            $modelVote = new m_vote();

            if(session()->get('login'))
            {
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            $data['platform'] = $modelVote->getDefaultPlatform()[0]->nom;
            $data['vote'] = $modelVote->getJeuxVote($data['platform']);
            $data['titre'] = '';
            $data['plateformes'] = $modelVote->getPlateformes();

            return view('v_header') . view('v_vote', $data) . view('v_footer');
        }
    }

    public function VoteJeux($plateforme)
    {
        if ($this->request->getMethod() === 'post') {
            $modelVote = new m_vote();

            if(session()->get('login'))
            {
                $modelVote->addVote(session()->get('login'), $this->request->getPost('jeu-input'));
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            $platformData = $modelVote->getPlatform($plateforme);
            if (!empty($platformData)) {
                $data['platform'] = $platformData[0]->nom;
                $data['vote'] = $modelVote->getJeuxVote($plateforme);
                $data['titre'] = 'Vote bien effectué';
                $data['plateformes'] = $modelVote->getPlateformes();

                return view('v_header') . view('v_vote', $data) . view('v_footer');
            }
            else
            {
                header("Location: " . base_url() . 'public/vote');
                exit;
            }
        }
        else
        {
            $modelVote = new m_vote();

            if(session()->get('login'))
            {
                $data['plateformesvote'] = $modelVote->hasVote(session()->get('login'));
            }

            $platformData = $modelVote->getPlatform($plateforme);
            if (!empty($platformData)) {
                $data['platform'] = $platformData[0]->nom;
                $data['vote'] = $modelVote->getJeuxVote($plateforme);
                $data['titre'] = '';
                $data['plateformes'] = $modelVote->getPlateformes();

                return view('v_header') . view('v_vote', $data) . view('v_footer');
            }
            else
            {
                header("Location: " . base_url() . 'public/vote');
                exit;
            }
        }
    }


}
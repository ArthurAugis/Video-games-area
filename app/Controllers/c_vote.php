<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_vote;

class c_vote extends BaseController
{
    public function index(): string
    {
        $modelVote = new m_vote();

        $data['vote'] = $modelVote->getJeuxVote();

        return view('v_header') . view('v_vote', $data) . view('v_footer');
    }
}
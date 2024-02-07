<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\m_quiz;

class c_quiz extends BaseController
{
    public function index(): string
    {
        $modelQuiz = new m_quiz();

        $data['quiz'] = $modelQuiz->getQuiz();

        return view('v_header') . view('v_quiz', $data) . view('v_footer');
    }
}
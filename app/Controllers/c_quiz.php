<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class c_quiz extends BaseController
{
    public function index(): string
    {
        return view('v_header') . view('v_quiz') . view('v_footer');
    }
}
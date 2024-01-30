<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class c_vote extends BaseController
{
    public function index(): string
    {
        return view('v_header') . view('v_vote') . view('v_footer');
    }
}
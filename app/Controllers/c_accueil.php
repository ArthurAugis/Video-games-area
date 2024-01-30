<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class c_accueil extends BaseController
{
    public function index(): string
    {
        return view('v_header') . view('v_accueil') . view('v_footer');
    }
}

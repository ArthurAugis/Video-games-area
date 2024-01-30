<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class c_tournois extends BaseController
{
    public function index(): string
    {
        return view('v_header') . view('v_tournois') . view('v_footer');
    }
}
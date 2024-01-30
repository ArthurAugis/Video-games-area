<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class c_prix extends BaseController
{
    public function index(): string
    {
        return view('v_header') . view('v_prix') . view('v_footer');
    }
}
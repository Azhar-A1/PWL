<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Member extends BaseController
{
    public function index()
    {
        return view('member_dashboard');
    }
}

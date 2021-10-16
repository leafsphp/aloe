<?php

namespace App\Controllers\Auth;

use Leaf\Auth;

class HomeController extends Controller
{
    public function index()
    {
        Auth::guard("auth");

        echo view("pages.auth.home");
    }
}

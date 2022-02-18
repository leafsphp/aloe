<?php

namespace App\Controllers\Auth;

class HomeController extends Controller
{
    public function index()
    {
        auth()->guard('auth');

        echo view('pages.auth.home');
    }
}

<?php

namespace App\Controllers\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        echo view('pages.auth.home');
    }
}

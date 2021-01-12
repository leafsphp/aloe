<?php

namespace App\Controllers\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $this->auth->guard("auth");

        render("pages.auth.home");
    }
}

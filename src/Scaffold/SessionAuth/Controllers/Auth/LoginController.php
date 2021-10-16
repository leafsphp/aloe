<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Leaf\Auth;

class LoginController extends Controller
{
    public function show()
    {
        Auth::guard("guest");

        echo view("pages.auth.login");
    }

    public function store()
    {
        Auth::guard("guest");

        list($username, $password) = request()->get(["username", "password"], true, true);

        $this->form->validate([
            "username" => "validUsername",
        ]);

        $user = Auth::login("users", [
            "username" => $username,
            "password" => $password
        ]);

        if (!$user) {
            return view("pages.auth.login", [
                "errors" => array_merge(
                    Auth::errors(),
                    $this->form->errors()
                ),
                "username" => $username,
                "password" => $password,
            ]);
        }
    }

    public function logout()
    {
        Auth::guard("auth");

        Auth::endSession("GUARD_LOGIN");
    }
}


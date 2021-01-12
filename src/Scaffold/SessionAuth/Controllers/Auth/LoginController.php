<?php

namespace App\Controllers\Auth;

use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        $this->auth->guard("guest");

        render("pages.auth.login");
    }

    public function store()
    {
        $this->auth->guard("guest");

        list($username, $password) = requestData(["username", "password"], true, true);

        $this->form->validate([
            "username" => "validUsername",
        ]);

        $user = $this->auth->login("users", [
            "username" => $username,
            "password" => $password
        ]);

        if (!$user) {
            return render("pages.auth.login", [
                "errors" => array_merge(
                    $this->auth->errors(),
                    $this->form->errors()
                ),
                "username" => $username,
                "password" => $password,
            ]);
        }
    }

    public function logout()
    {
        $this->auth->guard("auth");

        $this->auth->endSession("GUARD_LOGIN");
    }
}


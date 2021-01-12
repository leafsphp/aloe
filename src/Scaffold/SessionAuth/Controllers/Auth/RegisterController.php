<?php

namespace App\Controllers\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        $this->auth->guard("guest");

        render("pages.auth.register");
    }
    
    public function store()
    {
        $this->auth->guard("guest");

        $credentials = requestData(["username", "email", "password"]);

        $this->form->validate([
            "username" => "validUsername",
            "email" => "email",
            "password" => "required"
        ]);

        $this->auth->config("SESSION_ON_REGISTER", true);

        $user = $this->auth->register("users", $credentials, [
            "username", "email"
        ]);

        if (!$user) {
            return render("pages.auth.register", array_merge([
                "errors" => array_merge($this->auth->errors(), $this->form->errors()),
            ], request(["username", "email", "password"])));
        }
    }
}

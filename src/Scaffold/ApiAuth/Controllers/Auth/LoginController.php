<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class LoginController extends Controller
{
    public function index()
    {
        list($username, $password) = requestData(["username", "password"], true, true);

        Form::rule("max", function($field, $value, $params) {
            if (strlen($value) > $params) {
                Form::addError($field, "$field can't be more than $params characters");
                return false;
            }
        });

        $validation = Form::validate([
            "username" => "max:15",
            "password" => "min:8",
        ]);

        if (!$validation) throwErr(Form::errors());

        $user = Auth::login("users", [
            "username" => $username,
            "password" => $password
        ]);

        if (!$user) throwErr(Auth::errors());

        json($user);
    }

    public function logout()
    {
        // If you use session with your tokens, you
        // might want to remove all the saved data here
        json("Logged out successfully!");
    }
}

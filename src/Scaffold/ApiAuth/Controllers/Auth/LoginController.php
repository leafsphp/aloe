<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class LoginController extends Controller
{
    public function index()
    {
        list($username, $password) = request()->get(["username", "password"], true, true);

        Form::rule("max", function ($field, $value, $params) {
            if (strlen($value) > $params) {
                Form::addError($field, "$field can't be more than $params characters");
                return false;
            }
        });

        $validation = Form::validate([
            "username" => "max:15",
            "password" => "min:8",
        ]);

        if (!$validation) response()->throwErr(Form::errors());

        $user = Auth::login("users", [
            "username" => $username,
            "password" => $password
        ]);

        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }

    public function logout()
    {
        response()->json("Logged out successfully!");
    }
}

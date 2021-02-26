<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class LoginController extends Controller
{
    public function index()
    {
        Auth::guard("guest");

        list($username, $password) = requestData(["username", "password"], true, true);

        // You can now call leaf form methods statically.
        // Leaf v2.4.2 includes a new rule method which allows you to create
        // your own form rules
        Form::rule("max", function($field, $value, $params) {
            // the $params field holds the params passed to your rule
            if (strlen($value) > $params) {
                Form::addError($field, "$field can't be more than $params characters");
                return false;
            }
        });

        // You can also pass in custom parameters into your
        // form rules. The example below calls the max rule defined
        // above, and replaces the $params variable with 10.
        $validation = Form::validate([
            // To pass a param to a rule, just use :
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
        Auth::guard("auth");

        Auth::endSession("GUARD_LOGIN");
    }
}


<?php

namespace App\Controllers\Auth;

use Leaf\Form;

class LoginController extends Controller
{
    public function index()
    {
        $credentials = request()->get(['username', 'password']);

        Form::rule('max', function ($field, $value, $params) {
            if (strlen($value) > $params) {
                Form::addError($field, "$field can't be more than $params characters");
                return false;
            }
        });

        $validation = Form::validate([
            'username' => 'max:15',
            'password' => 'min:8',
        ]);

        if (!$validation) {
            response()->exit(Form::errors());
        }

        $user = auth()->login($credentials);

        if (!$user) {
            response()->exit(auth()->errors());
        }

        response()->json($user);
    }

    public function logout()
    {
        response()->json('Logged out successfully!');
    }
}

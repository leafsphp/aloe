<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class RegisterController extends Controller
{
    public function store()
    {
        $credentials = request(['username', 'email', 'password']);

        $validation = Form::validate([
            'username' => ['username', 'max:15'],
            'email' => 'email',
            'password' => 'min:8'
        ]);

        if (!$validation) response()->throwErr(Form::errors());

        $user = auth()->register($credentials, [
            'username', 'email'
        ]);

        if (!$user) response()->throwErr(auth()->errors());

        response()->json($user);
    }
}

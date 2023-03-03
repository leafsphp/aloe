<?php

namespace App\Controllers\Auth;

use Leaf\Auth;
use Leaf\Form;

class RegisterController extends Controller
{
    public function store()
    {
        $credentials = request()->get(['username', 'fullname', 'email', 'password']);

        $validation = Form::validate([
            'fullname' => 'required',
            'username' => ['username', 'max:15'],
            'email' => 'email',
            'password' => 'min:8'
        ]);

        if (!$validation) response()->exit(Form::errors());

        $user = auth()->register($credentials, [
            'username', 'email'
        ]);

        if (!$user) response()->exit(auth()->errors());

        response()->json($user);
    }
}

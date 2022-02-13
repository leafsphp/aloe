<?php

namespace App\Controllers\Auth;

use Leaf\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        auth()->guard('guest');

        echo view('pages.auth.register');
    }
    
    public function store()
    {
        auth()->guard('guest');

        $credentials = request()->get(['username', 'email', 'password']);

        $this->form->validate([
            'username' => 'validUsername',
            'email' => 'email',
            'password' => 'required'
        ]);

        auth()->config('SESSION_ON_REGISTER', true);

        $user = auth()->register($credentials, [
            'username', 'email'
        ]);

        if (!$user) {
            return view('pages.auth.register', array_merge(
                ['errors' => array_merge(auth()->errors(), $this->form->errors())],
                $credentials
            ));
        }
    }
}

<?php

namespace App\Controllers\Auth;

use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        auth()->guard('guest');

        echo view('pages.auth.login');
    }

    public function store()
    {
        auth()->guard('guest');

        $data = request()->get(['username', 'password']);

        $this->form->validate([
            'username' => 'validUsername',
        ]);

        $user = auth()->login($data);

        if (!$user) {
            echo view('pages.auth.login', array_merge($data, [
                'errors' => array_merge(
                    auth()->errors(),
                    $this->form->errors()
                ),
            ]));
        }
    }

    public function logout()
    {
        auth()->guard('auth');

        auth()->logout('GUARD_LOGIN');
    }
}

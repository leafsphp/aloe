<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Leaf\Auth;

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

        list($username, $password) = request()->get(['username', 'password'], true, true);

        $this->form->validate([
            'username' => 'validUsername',
        ]);

        $user = auth()->login([
            'username' => $username,
            'password' => $password
        ]);

        if (!$user) {
            return view('pages.auth.login', [
                'errors' => array_merge(
                    auth()->errors(),
                    $this->form->errors()
                ),
                'username' => $username,
                'password' => $password,
            ]);
        }
    }

    public function logout()
    {
        auth()->guard('auth');

        auth()->logout('GUARD_LOGIN');
    }
}

<?php

namespace App\Controllers\Auth;

class AccountController extends Controller
{
    public function user()
    {
        auth()->guard('auth');

        $user = auth()->user(['password']);

        if (!$user) {
            return auth()->logout('GUARD_LOGIN');
        }

        echo view('pages.auth.account', [
            'user' => $user,
        ]);
    }

    public function show_update()
    {
        auth()->guard('auth');

        $user = auth()->user();

        echo view('pages.auth.update', [
            'user' => auth()->id(),
            'username' => $user['username'] ?? null,
            'email' => $user['email'] ?? null,
            'name' => $user['name'] ?? null,
        ]);
    }

    public function update()
    {
        auth()->guard('auth');

        $data = request()->try(['username', 'email', 'name']);
        $uniques = ['username', 'email'];

        foreach ($uniques as $key => $unique) {
            if (!isset($data[$unique])) {
                unset($uniques[$key]);
            }
        }

        $user = auth()->update($data, $uniques);

        if (!$user) {
            return view('pages.auth.update', [
                'errors' => auth()->errors(),
                'username' => $data['username'] ?? null,
                'email' => $data['email'] ?? null,
                'name' => $data['name'] ?? null,
            ]);
        }

        response()->redirect('/user');
    }
}

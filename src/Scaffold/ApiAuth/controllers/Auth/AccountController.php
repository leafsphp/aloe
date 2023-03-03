<?php

namespace App\Controllers\Auth;

class AccountController extends Controller
{
    public function user()
    {
        $user = auth()->user(['password']);

        if (!$user) {
            response()->exit(auth()->errors());
        }

        response()->json($user);
    }

    public function update()
    {
        $data = request()->try(['username', 'email', 'name'], true, true);
        $uniques = ['username', 'email'];

        foreach ($uniques as $key => $unique) {
            if (!isset($data[$unique])) {
                unset($uniques[$key]);
            }
        }

        $user = auth()->update($data, $uniques);

        if (!$user) {
            response()->exit(auth()->errors());
        }

        response()->json($user);
    }
}

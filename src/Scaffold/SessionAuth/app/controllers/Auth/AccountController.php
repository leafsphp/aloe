<?php

namespace App\Controllers\Auth;

class AccountController extends Controller
{
    public function user()
    {
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
        $user = auth()->user();

        echo view('pages.auth.update', [
            'errors' => flash()->display('errors') ?? [],
            'name' => $user->name ?? null,
            'email' => $user->email ?? null,
        ]);
    }

    public function update()
    {
        $data = request()->validate([
            'email' => 'optional|email',
            'name' => 'optional|text',
        ]);

        if (!$data) {
            return response()
                ->withFlash('errors', request()->errors())
                ->redirect('/dashboard/user/update');
        }

        $success = auth()->update($data);

        if (!$success) {
            return response()
                ->withFlash('errors', auth()->errors())
                ->redirect('/dashboard/user/update');
        }

        response()->redirect('/dashboard/user');
    }
}

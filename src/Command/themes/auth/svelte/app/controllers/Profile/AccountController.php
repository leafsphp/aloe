<?php

namespace App\Controllers\Profile;

class AccountController extends Controller
{
    public function show_update()
    {
        $user = auth()->user();

        response()->inertia('profile/update', [
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
                ->redirect('/settings/profile', 303);
        }

        $success = auth()->update($data);

        if (!$success) {
            return response()
                ->withFlash('errors', auth()->errors())
                ->redirect('/settings/profile', 303);
        }

        response()->redirect('/dashboard', 303);
    }
}

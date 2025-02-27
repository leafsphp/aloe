<?php

namespace App\Controllers\Auth;

class LoginController extends Controller
{
    public function show()
    {
        $form = flash()->display('form') ?? [];

        response()->inertia('auth/login', array_merge($form, [
            'errors' => flash()->display('error') ?? [],
        ]));
    }

    public function store()
    {
        $data = request()->validate([
            'email' => 'email',
            'password' => 'min:8',
        ]);

        if (!$data) {
            response()
                ->withFlash('form', request()->body())
                ->withFlash('error', request()->errors())
                ->redirect('/auth/login', 303);
        }

        $success = auth()->login($data);

        if (!$success) {
            response()
                ->withFlash('form', request()->body())
                ->withFlash('error', request()->errors())
                ->redirect('/auth/login', 303);
        }

        response()->redirect('/dashboard', 303);
    }

    public function logout()
    {
        auth()->logout('/');
    }
}

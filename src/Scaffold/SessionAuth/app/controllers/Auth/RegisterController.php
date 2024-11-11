<?php

namespace App\Controllers\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        $form = flash()->display('form') ?? [];

        echo view('pages.auth.register', array_merge($form, [
            'errors' => flash()->display('error') ?? []
        ]));
    }

    public function store()
    {
        $credentials = request()->validate([
            'name' => 'string',
            'email' => 'email',
            'password' => 'min:8',
            'confirmPassword*' => 'matchesValueOf:password'
        ]);

        if (!$credentials) {
            return response()
                ->withFlash('form', request()->body())
                ->withFlash('error', request()->errors())
                ->redirect('/auth/register');
        }

        $success = auth()->register($credentials);

        if (!$success) {
            return response()
                ->withFlash('form', request()->body())
                ->withFlash('error', auth()->errors())
                ->redirect('/auth/register');
        }

        return response()->redirect('/dashboard');
    }
}

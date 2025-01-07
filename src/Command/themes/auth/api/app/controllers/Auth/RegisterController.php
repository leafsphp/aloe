<?php

namespace App\Controllers\Auth;

class RegisterController extends Controller
{
    public function store()
    {
        $credentials = request()->validate([
            'name' => 'string',
            'email' => 'email',
            'password' => 'min:8',
        ]);

        if (!$credentials) {
            return response()->exit([
                'message' => 'Validation failed',
                'data' => request()->errors(),
            ], 400);
        }

        $success = auth()->register($credentials);

        if (!$success) {
            return response()->exit([
                'message' => 'Registration failed',
                'data' => auth()->errors(),
            ], 400);
        }

        return response()->json([
            'message' => 'Registration successful',
            'data' => auth()->data(),
        ]);
    }
}

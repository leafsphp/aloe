<?php

namespace App\Controllers\Auth;

class LoginController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'email' => 'email',
            'password' => 'string',
        ]);

        if (!$data) {
            return response()->exit([
                'message' => 'Validation failed',
                'data' => request()->errors(),
            ], 400);
        }

        $success = auth()->login($data);

        if (!$success) {
            return response()->exit([
                'message' => 'Login failed',
                'data' => auth()->errors(),
            ], 400);
        }

        response()->json([
            'message' => 'Login successful',
            'data' => auth()->data(),
        ]);
    }

    public function logout()
    {
        auth()->logout();
    }
}

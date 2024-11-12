<?php

namespace App\Controllers\Auth;

class AccountController extends Controller
{
    public function index()
    {
        response()->json([
            'message' => 'User account',
            'data' => auth()->user()->get(),
        ]);
    }

    public function update()
    {
        $data = request()->validate([
            'email' => 'optional|email',
            'name' => 'optional|text',
        ]);

        if (!$data) {
            return response()->exit([
                'message' => 'Validation failed',
                'data' => request()->errors(),
            ], 400);
        }

        $success = auth()->update($data);

        if (!$success) {
            return response()->exit([
                'message' => 'Update failed',
                'data' => auth()->errors(),
            ], 400);
        }

        response()->json([
            'message' => 'User account updated',
            'data' => auth()->user()->get(),
        ]);
    }
}

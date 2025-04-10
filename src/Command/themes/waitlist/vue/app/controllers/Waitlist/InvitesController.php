<?php

namespace App\Controllers\Waitlist;

use App\Models\WaitlistInvite;
use Firebase\JWT\JWT;

class InvitesController extends Controller
{
    public function handle()
    {
        $data = request()->validate(['email' => 'email']);

        if (!$data) {
            return response()
                ->withFlash('error', request()->errors())
                ->redirect('/', 303);
        }

        $waitlistInvite = new WaitlistInvite();
        $waitlistInvite->token = JWT::encode(
            [
                'user.email' => $data['email'],
                'iat' => time(),
                'exp' => $expiresIn ?? (time() + 60 * 60 * 24 * 3), // 3 days
                'iss' => $_SERVER['HTTP_HOST'] ?? 'localhost',
            ],
            \Leaf\Auth\Config::get('token.secret') . '-waitlist',
            'HS256'
        );
        $waitlistInvite->save();

        // send email to user with the invite token

        return response()->json([
            'message' => 'Invite sent successfully.',
            'token' => $waitlistInvite->token,
        ]);
    }
}

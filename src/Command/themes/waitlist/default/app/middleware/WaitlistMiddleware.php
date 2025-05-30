<?php

namespace App\Middleware;

use Leaf\Middleware;

class WaitlistMiddleware extends Middleware
{
    public function call()
    {
        $allowedPaths = [
            '/',
            '/auth/login',
            '/waitlist',
            '/waitlist/invite',
            '/billing/callback',
            '/billing/webhook'
        ];

        $path = request()->getPathInfo();

        if (strpos($path, '/billing/') === 0) {
            return;
        }

        if (in_array($path, $allowedPaths)) {
            return;
        }

        if (
            !auth()->user() &&
            (!(
                ($inviteCode = request()->get('invite')) &&
                db()->select('waitlist_invites')->where('token', $inviteCode)->first()
            ))
        ) {
            response()->redirect('/', 303);
        }
    }
}

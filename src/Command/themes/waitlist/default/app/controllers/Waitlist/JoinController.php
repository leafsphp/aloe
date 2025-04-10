<?php

namespace App\Controllers\Waitlist;

use App\Models\WaitlistEmail;

class JoinController extends Controller
{
    public function handle()
    {
        $data = request()->validate(['email' => 'email']);

        if (!$data) {
            return response()->withFlash('error', request()->errors());
        }

        if (WaitlistEmail::where('email', $data['email'])->exists()) {
            return response()->redirect('/', 303);
        }

        $waitlistEmail = new WaitlistEmail();
        $waitlistEmail->email = $data['email'];
        $waitlistEmail->save();

        return response()->redirect('/', 303);
    }
}

<?php

namespace App\Controllers\Auth;

use Leaf\Auth;

class AccountController extends Controller
{
    public function user()
    {
        $user = Auth::user("users", ["password"]);

        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }

    public function update()
    {
        $userId = Auth::id();

        $data = request(["username", "email", "name"]);
        $dataKeys = array_keys($data);

        $where = ["id" => $userId];
        $uniques = ["username", "email"];

        foreach ($dataKeys as $key) {
            if (!$data[$key]) {
                unset($data[$key]);
                continue;
            }

            if (!strlen($data[$key])) {
                unset($data[$key]);
            }
        }

        foreach ($uniques as $key => $unique) {
            if (!isset($data[$unique])) {
                unset($uniques[$key]);
            }
        }

        $user = Auth::update("users", $data, $where, $uniques);

        if (!$user) response()->throwErr(Auth::errors());

        response()->json($user);
    }
}

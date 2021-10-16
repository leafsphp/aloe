<?php

namespace App\Controllers\Auth;

use Leaf\Auth;

class AccountController extends Controller
{
    public function user()
    {
        Auth::guard("auth");

        $user = Auth::user("users", ["password"]);

        if (!$user) {
            return Auth::endSession("GUARD_LOGIN");
        }

        echo view("pages.auth.account", [
            "user" => $user,
            "keys" => array_keys($user),
        ]);
    }

    public function show_update()
    {
        Auth::guard("auth");

        $user = Auth::user();

        echo view("pages.auth.update", [
            "user" => Auth::id(),
            "username" => $user["username"] ?? null,
            "email" => $user["email"] ?? null,
            "name" => $user["name"] ?? null,
        ]);
    }

    public function update()
    {
        Auth::guard("auth");

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

        if (!$user) {
            return view("pages.auth.update", [
                "errors" => Auth::errors(),
                "username" => $data["username"] ?? null,
                "email" => $data["email"] ?? null,
                "name" => $data["name"] ?? null,
            ]);
        }

        response()->redirect("/user");
    }
}

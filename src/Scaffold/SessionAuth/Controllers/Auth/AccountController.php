<?php

namespace App\Controllers\Auth;

class AccountController extends Controller
{
    public function user()
    {
        $this->auth->guard("auth");

        $user = $this->auth->user("users", ["password"]);

        if (!$user) {
            return $this->auth->endSession("GUARD_LOGIN");
        }

        render("pages.auth.account", [
            "user" => $user,
            "keys" => array_keys($user),
        ]);
    }

    public function show_update()
    {
        $this->auth->guard("auth");

        $user = $this->auth->user();

        render("pages.auth.update", [
            "user" => $this->auth->id(),
            "username" => $user["username"] ?? null,
            "email" => $user["email"] ?? null,
        ]);
    }

    public function update()
    {
        $this->auth->guard("auth");

        $userId = $this->auth->id();

        $data = request(["username", "email"]);
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

        $user = $this->auth->update("users", $data, $where, $uniques);

        if (!$user) {
            return render("pages.auth.update", [
                "errors" => $this->auth->errors(),
                "username" => $user["username"] ?? null,
                "email" => $user["email"] ?? null,
            ]);
        }

        response()->redirect("/user");
    }
}

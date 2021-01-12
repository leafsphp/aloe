<?php

namespace Aloe\Debugger\Controllers;

class DebuggersController extends \App\Controllers\Controller
{
    public function index()
    {
        $blade = new \Leaf\Blade;
        $blade->configure("vendor/leafs/aloe/src/Debugger/Views/", "storage/framework/views/");

        markup($blade->render("debugger", [
            "routes" => app()->routes(),
        ]));
    }
}

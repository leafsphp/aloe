<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Template Engine [EXPERIMENTAL]
    |--------------------------------------------------------------------------
    |
    | Leaf MVC unlike other frameworks tries to give you as much control as
    | you need. As such, you can decide which view engine to use.
    |
    */
    'viewEngine' => \Leaf\Blade::class,

    /*
    |--------------------------------------------------------------------------
    | Custom config method
    |--------------------------------------------------------------------------
    |
    | Configuration for your templating engine.
    |
    */
    'config' => function (\Leaf\Blade $engine, array $config) {
        $engine->configure($config['views'], $config['cache']);
    },

    /*
    |--------------------------------------------------------------------------
    | Custom render method
    |--------------------------------------------------------------------------
    |
    | This render method is triggered whenever render() is called
    | in your app if you're using a custom view engine.
    |
    */
    'render' => null,

    /*
    |--------------------------------------------------------------------------
    | Extend view engine
    |--------------------------------------------------------------------------
    |
    | Some view engines like blade allow you extend the engine to
    | add extra functions or directives. This is just the place to
    | do all of that. Extend is a function that accepts an instance
    | of your view engine which you can 'extend'
    |
    */
    'extend' => null,
];

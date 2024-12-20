<?php

auth()->middleware('auth.required', function () {
    response()->redirect('/auth/login');
});

auth()->middleware('auth.guest', function () {
    response()->redirect('/dashboard');
});

app()->group('/auth', [
    'middleware' => 'auth.guest',
    function () {
        app()->get('/login', 'Auth\LoginController@show');
        app()->post('/login', 'Auth\LoginController@store');
        app()->get('/register', 'Auth\RegisterController@show');
        app()->post('/register', 'Auth\RegisterController@store');
        // Reset and recover account will be added later
    }
]);

app()->post('/auth/logout', ['middleware' => 'auth.required', 'Auth\LoginController@logout']);

app()->group('/dashboard', [
    'middleware' => 'auth.required',
    function () {
        app()->get('/', 'Auth\DashboardController@index');

        app()->group('/user', function () {
            app()->get('/', 'Auth\AccountController@user');
            app()->get('/update', 'Auth\AccountController@show_update');
            app()->post('/update', 'Auth\AccountController@update');
        });
    }
]);

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
    },
]);

app()->post('/auth/logout', [
    'middleware' => 'auth.required',
    'Auth\LoginController@logout'
]);

app()->group('/dashboard', [
    'middleware' => 'auth.required',
    function () {
        app()->get('/', 'Auth\DashboardController@index');
    },
]);

app()->group('/settings', function () {
    app()->get('/profile', 'Profile\AccountController@show_update');
    app()->patch('/profile', 'Profile\AccountController@update');
});

<?php

app()->group('/auth', function () {
    app()->get('/login', 'Auth\LoginController@show');
    app()->post('/login', 'Auth\LoginController@store');
    app()->get('/register', 'Auth\RegisterController@show');
    app()->post('/register', 'Auth\RegisterController@store');
    app()->get('/logout', 'Auth\LoginController@logout');
    // Reset and recover account will be added later
});

app()->get('/home', 'Auth\HomeController@index');

app()->group('/user', function () {
    app()->get('/', 'Auth\AccountController@user');
    app()->get('/update', 'Auth\AccountController@show_update');
    app()->post('/update', 'Auth\AccountController@update');
});

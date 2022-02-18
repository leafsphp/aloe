<?php

app()->group('/debugger', ['namespace' => '\Aloe\Debugger\Controllers', function () {
    app()->get('/', 'DebuggersController@index');
}]);

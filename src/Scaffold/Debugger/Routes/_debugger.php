<?php

app()->setNamespace("\Aloe\Debugger\Controllers");

Route("GET", "/debugger", "DebuggersController@index");

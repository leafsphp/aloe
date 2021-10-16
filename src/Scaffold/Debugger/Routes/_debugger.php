<?php

app()->setNamespace("\Aloe\Debugger\Controllers");

app()->get("/debugger", "DebuggersController@index");

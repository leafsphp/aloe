<?php

return [
    /*
    |-----------------------------------------------------------------
    | Redis host
    |-----------------------------------------------------------------
    |
    | Set the host for redis connection
    |
    */
    'host' => _env('REDIS_HOST', '127.0.0.1'),

    /*
    |-----------------------------------------------------------------
    | Redis host port
    |-----------------------------------------------------------------
    |
    | Set the port for redis host
    |
    */
    'port' => _env('REDIS_PORT', 6379),

    /*
    |-----------------------------------------------------------------
    | Redis auth
    |-----------------------------------------------------------------
    |
    | Set the password for redis connection
    |
    */
    'password' => _env('REDIS_PASSWORD', null),

    /*
    |-----------------------------------------------------------------
    | Redis session handler
    |-----------------------------------------------------------------
    |
    | Set redis as session save handler
    |
    */
    'session' => _env('REDIS_SESSION', false),

    /*
    |-----------------------------------------------------------------
    | Redis connection timeout
    |-----------------------------------------------------------------
    |
    | Value in seconds (optional, default is 0.0 meaning unlimited)
    |
    */
    'connection.timeout' => 0.0,

    /*
    |-----------------------------------------------------------------
    | Redis connection reserved
    |-----------------------------------------------------------------
    |
    | should be null if $retryInterval is specified
    |
    */
    'connection.reserved' => null,

    /*
    |-----------------------------------------------------------------
    | Redis session handler
    |-----------------------------------------------------------------
    |
    | Connection retry interval in milliseconds.
    |
    */
    'connection.retryInterval' => 0,

    /*
    |-----------------------------------------------------------------
    | Redis connection read timeout
    |-----------------------------------------------------------------
    |
    | Value in seconds (optional, default is 0 meaning unlimited
    |
    */
    'connection.readTimeout' => 0.0,

    /*
    |-----------------------------------------------------------------
    | Redis session save_path
    |-----------------------------------------------------------------
    |
    | Save path for redis session. Leave null to automatically
    | generate the session save path. You can also use
    | multiple save urls by passing in an array.
    |
    */
    'session.savePath' => null,

    /*
    |-----------------------------------------------------------------
    | Redis session save_path options
    |-----------------------------------------------------------------
    |
    | Options for session save path. You can pass in multiple
    | options in the order of the save path above.
    |
    */
    'session.saveOptions' => [],
];

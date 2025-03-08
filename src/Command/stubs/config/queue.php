<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the queue connections below you wish
    | to use as your default connection for all queue work.
    |
    */
    'default' => _env('QUEUE_CONNECTION', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection options for every queue backend
    | used by your application. An example configuration is provided for
    | each backend supported by Leaf. You're also free to add more.
    |
    | Drivers: "redis", "database", "file (BETA)"
    |
    */
    'connections' => [
        'database' => [
            'driver' => 'database',
            'connection' => _env('DB_QUEUE_CONNECTION', 'default'),
            'table' => _env('DB_QUEUE_TABLE', 'leaf_php_jobs'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => _env('REDIS_QUEUE_CONNECTION', 'default'),
            'table' => _env('REDIS_QUEUE', 'leaf_php_jobs'),
        ],
    ],
];

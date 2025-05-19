<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default FS Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default FS connection that should be used
    | by Leaf FS for bucket storage. By default, FS uses local storage
    | you can use the `withBucket` function to switch to bucket storage.
    |
    */
    'default' => _env('FS_CONNECTION', 's3'),

    /*
    |--------------------------------------------------------------------------
    | FS Connections
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many FS Bucket connections as necessary. For
    | now, only s3-compatible buckets are supported. You can also also
    | configure multiple buckets with the same driver (just add another)
    |
    | Supported drivers: "s3"
    |
    */
    'connections' => [
        's3' => [
            'driver' => 's3',
            'key' => _env('AWS_ACCESS_KEY_ID'),
            'secret' => _env('AWS_SECRET_ACCESS_KEY'),
            'region' => _env('AWS_DEFAULT_REGION'),
            'bucket' => _env('AWS_BUCKET'),
            'url' => _env('AWS_URL'),
            'endpoint' => _env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => _env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `php leaf link` command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */
    'links' => [
        PublicPath('storage') => StoragePath('app/public'),
    ],

];

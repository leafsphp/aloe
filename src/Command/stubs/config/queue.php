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
        'redis' => [
            'host' => _env('REDIS_HOST', '127.0.0.1'),
            'port' => _env('REDIS_PORT', '6379'),
            'password' => _env('REDIS_PASSWORD', ''),
            'dbname' => _env('REDIS_DB', 0),
            'after_commit' => false,
        ],

        'database' => [
            'driver' => 'database',
            'connection' => _env('DB_QUEUE_CONNECTION'),
            'table' => _env('DB_QUEUE_TABLE', 'leaf_php_jobs'),
            'queue' => _env('DB_QUEUE', 'default'),
            'retry_after' => (int) _env('DB_QUEUE_RETRY_AFTER', 90),
            'after_commit' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Worker config
    |--------------------------------------------------------------------------
    |
    | This section sets up the configuration for your worker. This config
    | is used by default when you dispatch a job. You can override this
    | config by passing a config array to the dispatch method.
    |
    */
    'workerConfig' => [
        /*
        |----------------------------------------------------------------------
        | Job execution delay
        |----------------------------------------------------------------------
        |
        | This option allows you to set a delay for when a job should
        | be executed. This is useful for scheduling jobs to run
        | at a later time.
        |
        */
        'delay' => 0,

        /*
        |----------------------------------------------------------------------
        | Delay before retry
        |----------------------------------------------------------------------
        |
        | This option allows you to set a delay for when a job should
        | be retried. This is useful when you need to setup
        | something before retrying a job.
        |
        */
        'delayBeforeRetry' => 0,

        /*
        |----------------------------------------------------------------------
        | Expire time
        |----------------------------------------------------------------------
        |
        | Set a time limit for how long a job should be kept in the queue.
        | This is useful for archiving old jobs that you may need to
        | reference later for data or other purposes.
        |
        */
        'expire' => 60,

        /*
        |----------------------------------------------------------------------
        | Force job execution
        |----------------------------------------------------------------------
        |
        | Force a job to run even if it has expired or reached its retry
        | limit. This is useful for jobs that you need to run
        | at all costs.
        |
        */
        'force' => false,

        /*
        |----------------------------------------------------------------------
        | Memory limit
        |----------------------------------------------------------------------
        |
        | This option allows you to set a memory limit for the worker.
        | This is useful for preventing memory leaks and
        | other memory related issues.
        |
        */
        'memory' => 128,

        /*
        |----------------------------------------------------------------------
        | Quit when queue is empty
        |----------------------------------------------------------------------
        |
        | Should the worker should quit when the queue is empty?
        | By default, the worker will keep running even when
        | the queue is empty.
        |
        */
        'quitOnEmpty' => false,

        /*
        |----------------------------------------------------------------------
        | Worker sleep time
        |----------------------------------------------------------------------
        |
        | Set how long the worker should sleep when the queue is empty.
        | This is useful for preventing the worker from consuming
        | too much CPU when the queue is empty.
        |
        */
        'sleep' => 3,

        /*
        |----------------------------------------------------------------------
        | Queue timeout
        |----------------------------------------------------------------------
        |
        | This option allows you to set a timeout for the queue.
        | This is useful for preventing the queue from
        | running for too long.
        |
        */
        'timeout' => 60,

        /*
        |----------------------------------------------------------------------
        | Job retry limit
        |----------------------------------------------------------------------
        |
        | This option allows you to set a retry limit for a job.
        | This is useful for preventing a job from
        | running too many times.
        |
        */
        'tries' => 3,
    ],
];

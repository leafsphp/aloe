<?php

namespace Aloe\Command;

use \Aloe\Command;

class DatabaseInstallCommand extends Command
{
    protected static $defaultName = 'db:install';
    public $description = 'Create new database from .env variables';
    public $help = 'Create new database from .env variables';

    protected function handle()
    {
        $host = _env('DB_HOST');
        $user = _env('DB_USERNAME');
        $password = _env('DB_PASSWORD');
        $database = _env('DB_DATABASE');
        $dbConnection = _env('DB_CONNECTION', 'mysql');
        $port = empty(_env('DB_PORT')) ? 3306 : _env('DB_PORT');

        db()->connect([
            'dbtype' => MvcConfig('database')['connections'][$dbConnection]['driver'] ?? 'mysql',
            'host' => $host,
            'username' => $user,
            'password' => $password,
            'port' => $port,
        ]);

        if (db()->create($database)->execute()) {
            $this->info("$database created successfully.");
            return 0;
        }

        $this->error("$database could not be created.");
        return 1;
    }
}

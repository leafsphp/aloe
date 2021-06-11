<?php

namespace Aloe\Command;

use \Aloe\Command;

class DatabaseInstallCommand extends Command
{
    protected static $defaultName = "db:install";
    public $description = "Create new database from .env variables";
    public $help = "Create new database from .env variables";

    protected function handle()
    {
        $host = getenv("DB_HOST");
        $user = getenv("DB_USERNAME");
        $password = getenv("DB_PASSWORD");
        $database = getenv("DB_DATABASE");
        $port = empty(getenv("DB_PORT")) ? 3306 : getenv("DB_DATABASE");

        if (\mysqli_query(
            \mysqli_connect($host, $user, $password, "", $port),
            "CREATE DATABASE `$database`"
        )) {
            return $this->info("$database created successfully.");
        }

        return $this->error("$database could not be created.");
    }
}

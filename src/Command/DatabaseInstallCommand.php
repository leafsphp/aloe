<?php
namespace Aloe\Command;

class DatabaseInstallCommand extends \Aloe\Command
{
    public $name = "db:install";
    public $description = "Create new database from .env variables";
    public $help = "Create new database from .env variables";

    public function handle()
    {
		$host = getenv("DB_HOST");
		$user = getenv("DB_USERNAME");
		$password = getenv("DB_PASSWORD");
        $database = getenv("DB_DATABASE");
        
        if (\mysqli_query(
            \mysqli_connect($host, $user, $password, ""),
            "CREATE DATABASE `$database`"
        )) {
            return $this->info("$database created successfully.");
        }
        
        return $this->error("$database could not be created.");
    }
}

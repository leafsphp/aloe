<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DatabaseDropCommand extends Command
{
    protected static $defaultName = 'db:drop';
    public $description = 'Drop tables in the database';
    public $help = "Drop table(s) in your database, you can use -f to specify the schema you want to drop\n";

    protected function config()
    {
        $this->setOption('file', 'f', 'optional', 'Drop a particular schema file');
    }

    protected function handle()
    {
        $fileToDrop = $this->option('file');
        $schemaFiles = glob(Config::rootpath(DatabasePath('*.yml')));

        foreach ($schemaFiles as $migration) {
            if ($fileToDrop && strpos($migration, Str::snake($fileToDrop)) === false) {
                continue;
            }

            // static::$capsule::schema()->dropIfExists('users');
        }

        if ($fileToDrop && !in_array($fileToDrop, $schemaFiles)) {
            $this->error("$fileToDrop not found!");
            return 1;
        }

        $this->info(
            "Schema files dropped!\n"
        );

        return 0;
    }
}

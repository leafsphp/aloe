<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseRollbackCommand extends Command
{
    protected static $defaultName = 'db:rollback';
    public $description = 'Rollback database to a previous state';
    public $help = "Rollback database to a previous state, add -s to time-travel to a specific state, add -f to rollback a specific schema file.\n";

    protected function config()
    {
        $this
            ->setOption('step', 's', 'optional', 'The batch to rollback', '1')
            ->setOption('file', 'f', 'optional', 'Rollback a particular file');
    }

    protected function handle()
    {
        $step = $this->option('step');
        $fileToRollback = $this->option('file');
        $schemaFiles = glob(Config::rootpath(DatabasePath('*.yml')));

        foreach ($schemaFiles as $migration) {
            //
        }

        if ($fileToRollback && !in_array($fileToRollback, $schemaFiles)) {
            $this->error("$fileToRollback not found!");

            return 1;
        }

        $this->info("Database rollback completed!\n");

        return 0;
    }
}

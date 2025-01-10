<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseRollbackCommand extends Command
{
    protected static $defaultName = 'db:rollback';
    public $description = 'Rollback database to a previous state';
    public $help = "Rollback database to a previous state, add -s to time-travel to a specific state.\n";

    protected function config()
    {
        $this->setArgument('file', 'optional', 'Rollback a particular file');
        $this->setOption('step', 's', 'optional', 'The batch to rollback', '1');
    }

    protected function handle()
    {
        $fileToMigrate = $this->argument('file');
        $migrations = glob(Config::rootpath(AppPaths('database') . DIRECTORY_SEPARATOR . '*.yml'));

        foreach ($migrations as $migration) {
            $currentFileName = path($migration)->basename();

            if ($fileToMigrate && rtrim($currentFileName, '.yml') !== rtrim($fileToMigrate, '.yml')) {
                continue;
            }

            $this->writeln("> db rollback on <comment>$currentFileName</comment>");

            if (
                !\Leaf\Schema::rollback(
                    $migration,
                    (int) $this->option('step')
                )
            ) {
                $this->error("Could not rollback $currentFileName");

                return 1;
            }
        }

        $this->info("Database rollback completed!\n");

        return 0;
    }
}

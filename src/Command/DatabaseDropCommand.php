<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseDropCommand extends Command
{
    protected static $defaultName = 'db:drop';
    public $description = 'Drop database tables and reset migration history';
    public $help = "Drop all database tables and reset migration history. You can specify a file to drop only that migration.\n";

    protected function config()
    {
        $this->setArgument('file', 'optional', 'Rollback a particular file');
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

            $this->writeln("> db drop on <comment>$currentFileName</comment>");

            if (!\Leaf\Schema::drop($migration)) {
                $this->error("Could not drop $currentFileName");
                return 1;
            }
        }

        $this->info("Database drop completed!\n");

        return 0;
    }
}

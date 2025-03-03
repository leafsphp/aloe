<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DatabaseResetCommand extends Command
{
    protected static $defaultName = 'db:reset';
    public $description = 'Reset migration history + db tables';
    public $help = "Clear all database tables, and migrate afresh. Add --seed to seed db\n";

    protected function config()
    {
        $this->setArgument('file', 'optional', 'Rollback a particular file');
        $this->setOption('seed', 's', 'none', 'Seed the database after migration');
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

            $this->writeln("> db reset on <comment>$currentFileName</comment>");

            if (!\Leaf\Schema::reset(fileToReset: $migration)) {
                $this->error("Could not reset $currentFileName");
                return 1;
            }

            if ($this->option('seed')) {
                if (!\Leaf\Schema::seed($migration)) {
                    $this->error("Could not seed $currentFileName");
                    return 1;
                }

                $this->writeln("> $currentFileName seeded successfully!");
            }
        }

        $this->info("Database reset completed!\n");

        return 0;
    }
}

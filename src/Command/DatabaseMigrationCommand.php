<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseMigrationCommand extends Command
{
    protected static $defaultName = 'db:migrate';
    public $description = 'Migrate your db schema files';
    public $help = "Run the migrations defined in the migrations directory\n";

    protected function config()
    {
        $this->setArgument('file', 'optional', 'Rollback a particular file');
        $this->setOption('seed', 's', 'none', 'Run seeds after migration');
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

            $this->writeln("> db migration on <comment>$currentFileName</comment>");

            if (!\Leaf\Schema::migrate($migration)) {
                $this->error("Could not migrate $currentFileName");

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

        $this->info("Database migration completed!\n");

        return 0;
    }

    public function createDatabase()
    {
        $database = _env('DB_DATABASE');

        \Leaf\Database::initDb();

        if (db()->create($database)->execute()) {
            $this->info("$database created successfully.");

            return 0;
        }

        $this->error("$database could not be created.");
    }
}

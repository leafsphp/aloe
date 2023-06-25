<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DatabaseRollbackCommand extends Command
{
    protected static $defaultName = 'db:rollback';
    public $description = 'Rollback all database migrations';
    public $help = "Rollback database migrations, add -f to rollback a specific file. Don\'t use -s and -f together\n";

    protected function config()
    {
        $this
            ->setOption('step', 's', 'optional', 'The batch to rollback', 'all')
            ->setOption('file', 'f', 'optional', 'Rollback a particular file');
    }

    protected function handle()
    {
        $migrations = glob(Config::rootpath(MigrationsPath('*.php')));

        $step = $this->option('step');
        $fileToRollback = $this->option('file');

        if ($step !== 'all') {
            $migrations = array_slice($migrations, -abs($step), abs($step), true);
        }

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);

            if (!$fileToRollback) {
                $this->down($file, $migration);
            }

            if ($fileToRollback && strpos($migration, Str::snake("_create_$fileToRollback.php")) !== false) {
                $this->down($file, $migration);
                $this->info(
                    "Database rollback completed!\n"
                );
                return 0;
            }
        }

        if ($fileToRollback && !in_array($fileToRollback, $migrations)) {
            $this->error("$fileToRollback not found!");
            return 1;
        }

        $this->info("Database rollback completed!\n");
        return 0;
    }

    protected function down($file, $migration)
    {
        require_once $migration;
        $className = Str::studly(\substr($file['filename'], 17));

        $migrationName = str_replace([Config::rootpath(MigrationsPath()), '.php'], '', $migration);

        $class = new $className;
        $class->down();

        $this->writeln('> db rollback on ' . asComment($migrationName));
    }
}

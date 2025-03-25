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

        if (empty($migrations)) {
            $this->error("No schema files found.");
            return 1;
        }

        $this->createDatabase();

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
        $host = _env('DB_HOST');
        $user = _env('DB_USERNAME');
        $password = _env('DB_PASSWORD');
        $database = _env('DB_DATABASE');
        $dbCharset = _env('DB_CHARSET', 'utf8');
        $dbConnection = _env('DB_CONNECTION', 'mysql');
        $port = empty(_env('DB_PORT')) ? 3306 : _env('DB_PORT');
        $dbCollation = _env('DB_COLLATION', 'utf8_unicode_ci');

        db()->addConnections([
            'precheck' => [
                'dbtype' => (MvcConfig('database')['connections'][$dbConnection]['driver'] ?? 'mysql'),
                'host' => $host,
                'username' => $user,
                'password' => $password,
                'port' => $port,
            ]
        ]);

        if ((MvcConfig('database')['connections'][$dbConnection]['driver'] ?? 'mysql') === 'sqlite') {
            $this->writeln("> Verifying database...");

            if (!file_exists($database)) {
                \Leaf\FS\File::create($database, null, [
                    'recursive' => true
                ]);
            }

            return 0;
        }

        if ($host !== 'localhost' && $host !== '127.0.0.1') {
            return 0;
        }

        if (db('precheck')->query("CREATE DATABASE IF NOT EXISTS $database CHARACTER SET $dbCharset COLLATE $dbCollation;")->execute()) {
            $this->writeln("> Verifying database...");
            return 0;
        }

        $this->error("$database could not be created.\n");
    }
}

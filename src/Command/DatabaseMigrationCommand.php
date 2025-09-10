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

        foreach ($migrations as $migration) {
            $currentFileName = path($migration)->basename();

            if ($fileToMigrate && rtrim($currentFileName, '.yml') !== rtrim($fileToMigrate, '.yml')) {
                continue;
            }

            $this->writeln("> db migration on <comment>$currentFileName</comment>");

            $this->createDatabase($migration);

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

    public function createDatabase(string $migration)
    {
        $connection = MvcConfig('database')['connections'][
            \Leaf\Schema::getConnection($migration) ?? MvcConfig('database')['default']
        ];

        try {
            if ($connection['driver'] === 'sqlite') {
                if (!file_exists($connection['database'])) {
                    \Leaf\FS\File::create($connection['database'], null, [
                        'recursive' => true
                    ]);
                }

                return 0;
            }

            if ($connection['host'] !== 'localhost' && $connection['host'] !== '127.0.0.1') {
                return 0;
            }

            db()->addConnections([
                'precheck' => [
                    'dbtype' => $connection['driver'],
                    'host' => $connection['host'],
                    'username' => $connection['username'],
                    'password' => $connection['password'],
                    'port' => $connection['port'],
                ]
            ]);

            if ($connection['driver'] === 'pgsql') {
                $connectionExists = db('precheck')->query("SELECT 1 FROM pg_database WHERE datname = '{$connection['database']}';")->execute()->fetchColumn();

                if (!$connectionExists && db('precheck')->query("CREATE DATABASE {$connection['database']};")->execute()) {
                    return 0;
                }
            }

            if ($connection['driver'] === 'mysql' && db('precheck')->query("CREATE DATABASE IF NOT EXISTS `{$connection['database']}` CHARACTER SET {$connection['charset']} COLLATE {$connection['collation']};")->execute()) {
                return 0;
            }
        } catch (\Throwable $th) {
            $this->error("{$connection['database']} could not be created.\n {$th->getMessage()}");
        }
    }
}

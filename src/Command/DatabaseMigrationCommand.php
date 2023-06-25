<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DatabaseMigrationCommand extends Command
{
    protected static $defaultName = 'db:migrate';
    public $description = 'Run the database migrations';
    public $help = "Run the migrations defined in the migrations directory\n";

    protected function config()
    {
        $this->setOption('file', 'f', 'optional', 'Rollback a particular file');
        $this->setOption('seed', 's', 'none', 'Run seeds after migration');
    }

    protected function handle()
    {
        $fileToRollback = $this->option('file');
        $migrations = glob(Config::rootpath(MigrationsPath('*.php')));

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);
            $filename = $file['filename'];

            if ($filename !== 'Schema') :
                $className = Str::studly(\substr($filename, 17));

                if ($fileToRollback) {
                    if (strpos($migration, Str::snake("_create_$fileToRollback.php")) !== false) {
                        $this->migrate($className, $filename);
                        $this->info('db migration on ' . asComment(str_replace(Config::rootpath(MigrationsPath()), '', $migration)));

                        if ($this->option('seed')) {
                            $seederClass = $this->seedTable(str_replace(
                                ['Create'],
                                '',
                                Str::studly(\substr($filename, 17))
                            ));

                            if ($seederClass) {
                                $this->writeln(asComment($seederClass) . ' seeded successfully!');
                            }
                        }

                        $this->info("Database migration completed!\n");
                        return 0;
                    }

                    continue;
                } else {
                    $this->migrate($className, $filename);
                    $this->writeln('> db migration on ' . asComment(str_replace(Config::rootpath(MigrationsPath()), '', $migration)));

                    if ($this->option('seed')) {
                        $seederClass = $this->seedTable(str_replace(
                            'Create',
                            '',
                            Str::studly(\substr($filename, 17))
                        ));

                        if ($seederClass) {
                            $this->writeln(asComment($seederClass) . ' seeded successfully!');
                        }
                    }
                }
            endif;
        }

        $this->info("Database migration completed!\n");
        return 0;
    }

    protected function migrate($className, $filename)
    {
        require_once Config::rootpath(MigrationsPath("$filename.php", false));

        $class = new $className;
        $class->up();
    }

    protected function seedTable($table)
    {
        $className = "\App\Database\Seeds\\" . Str::plural($table) . "Seeder";

        if (!class_exists($className)) return false;

        $class = new $className;
        $class->run();

        return $className;
    }
}

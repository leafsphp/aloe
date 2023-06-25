<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DatabaseResetCommand extends Command
{
    protected static $defaultName = 'db:reset';
    public $description = 'Rollback, migrate and seed database';
    public $help = "To prevent seeding, add -s\n";

    protected function config()
    {
        $this->setOption('noSeed', 's', 'none', 'Prevent seeding of database');
    }

    protected function handle()
    {
        $this->rollback();
        $this->startMigration();
        $this->info("Database reset completed!\n");

        return 0;
    }

    protected function rollback() {
        $migrations = glob(Config::rootpath(MigrationsPath('*.php')));

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);
            $this->down($file, $migration);
        }

        $this->info("Database rollback completed!\n");
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

    protected function startMigration()
    {
        $migrations = glob(Config::rootpath(MigrationsPath('*.php')));

        foreach ($migrations as $migration) {
            $file = pathinfo($migration);
            $filename = $file['filename'];

            if ($filename !== 'Schema') :
                $className = Str::studly(\substr($filename, 17));

                $this->migrate($className, $filename);
                $this->writeln('> db migration on ' . asComment(str_replace(Config::rootpath(MigrationsPath()), '', $migration)));

                if (!$this->option('noSeed')) {
                    $seederClass = $this->seedTable(str_replace(
                        'Create',
                        '',
                        Str::studly(\substr($filename, 17))
                    ));

                    if ($seederClass) {
                        $this->writeln(asComment($seederClass) . ' seeded successfully!');
                    }
                }
            endif;
        }

        $this->info("Database migration completed!\n");
    }

    protected function migrate($className, $filename)
    {
        require_once Config::rootpath(MigrationsPath("$filename.php", false));

        $class = new $className;
        $class->up();
    }

    protected function seedTable($table)
    {
        $className = '\App\Database\Seeds\\' . Str::plural($table) . 'Seeder';

        if (!class_exists($className)) return false;

        $class = new $className;
        $class->run();

        return $className;
    }
}

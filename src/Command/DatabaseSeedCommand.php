<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseSeedCommand extends Command
{
    protected static $defaultName = 'db:seed';
    public $description = 'Seed the database with records';
    public $help = 'Seed the database with records';

    protected function config()
    {
        $this->setArgument('file', 'optional', 'Rollback a particular file');
    }

    protected function handle()
    {
        $fileToSeed = $this->argument('file');
        $seeds = glob(Config::rootpath(AppPaths('database') . DIRECTORY_SEPARATOR . '*.yml'));

        foreach ($seeds as $seed) {
            $currentFileName = path($seed)->basename();

            if ($fileToSeed && rtrim($currentFileName, '.yml') !== rtrim($fileToSeed, '.yml')) {
                continue;
            }

            if (!\Leaf\Schema::seed($seed)) {
                $this->error("Could not seed $currentFileName");
                return 1;
            }

            $this->writeln("> $currentFileName seeded successfully!");
        }

        $this->info("Database seeding completed!\n");

        return 0;
    }
}

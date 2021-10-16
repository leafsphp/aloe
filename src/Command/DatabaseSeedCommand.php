<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseSeedCommand extends Command
{
    protected static $defaultName = "db:seed";
    public $description = "Seed the database with records";
    public $help = "Seed the database with records";

    protected function handle()
    {
        if (!file_exists(Config::seedsPath("DatabaseSeeder.php"))) {
            return $this->error("DatabaseSeeder not found! Refer to the docs.");
        }

        $seeder = new Config::$seeder;
        $seeds = glob(Config::seedsPath("*.php"));

        if (count($seeds) === 1) {
            return $this->error("No seeds found! Create one with the g:seed command.");
        }

        if (count($seeder->run()) === 0) {
            return $this->error("No seeds registered. Add your seeds in DatabaseSeeder.php");
        }

        foreach ($seeder->run() as $seed) {
            $seeder->call($seed);
            $this->writeln("> " . asComment($seed) . " seeded successfully");
        }

        $this->info("Database seed complete");
    }
}

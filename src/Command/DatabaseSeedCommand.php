<?php

namespace Aloe\Command;

use Aloe\Command;

class DatabaseSeedCommand extends Command
{
    protected static $defaultName = 'db:seed';
    public $description = 'Seed the database with records';
    public $help = 'Seed the database with records';

    protected function handle()
    {
        if (!file_exists(Config::rootpath(SeedsPath('DatabaseSeeder.php')))) {
            $this->error('DatabaseSeeder not found! Refer to the docs.');
            return 1;
        }

        $seeder = new Config::$seeder;
        $seeds = glob(Config::rootpath(SeedsPath('*.php')));

        if (count($seeds) === 1) {
            $this->error('No seeds found! Create one with the g:seed command.');
            return 1;
        }

        if (count($seeder->run()) === 0) {
            $this->error('No seeds registered. Add your seeds in DatabaseSeeder.php');
            return 1;
        }

        foreach ($seeder->run() as $seed) {
            $seeder->call($seed);
            $this->writeln('> ' . asComment($seed) . ' seeded successfully');
        }

        $this->info('Database seed complete');
        return 0;
    }
}

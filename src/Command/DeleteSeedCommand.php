<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteSeedCommand extends Command
{
    protected static $defaultName = 'd:seed';
    public $description = 'Delete a model seeder';
    public $help = 'Delete a model seeder';

    protected function config()
    {
        $this->setArgument('seed', 'required', 'seeder name');
    }

    protected function handle()
    {
        $seeder = Str::studly($this->argument('seed'));

        if (!strpos($seeder, 'Seeder')) {
            $seeder = str::plural($seeder);
            $seeder .= 'Seeder';
        }

        $seederFile = Config::rootpath(SeedsPath("$seeder.php"));

        if (!file_exists($seederFile)) {
            $this->error("$seeder doesn't exist!");
            return 1;
        }

        if (!unlink($seederFile)) {
            $this->error("Couldn't delete $seeder, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$seeder deleted successfully");
        return 0;
    }
}

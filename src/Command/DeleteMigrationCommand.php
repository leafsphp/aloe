<?php

namespace Aloe\Command;

use Aloe\Command;
use Leaf\Str;

class DeleteMigrationCommand extends Command
{
    public $name = "d:migration";
    public $description = "Delete a migration";
    public $help = "Delete a particular migration file";

    public function config()
    {
        $this->setArgument('file', "required", 'File to delete');
    }

    public function handle()
    {
        $fileToDelete = strtolower(Str::snake(Str::plural($this->argument('file'))));
        $migrations = glob(Config::migrations_path("*_$fileToDelete.php"));

        if (count($migrations) === 0) {
            return $this->error("$fileToDelete not found");
        }

        $displayNames = [];
        $answers = [];

        foreach ($migrations as $migration) {
            $displayNames[] = str_replace(Config::migrations_path(), "", $migration);
        }

        if (count($migrations) === 1) {
            $answers = $displayNames;
        }

        if (count($migrations) > 1) {
            $answers = $this->multiChoice(
                count($migrations) . " '$fileToDelete' found. Select those to delete:" .
                asInfo(" eg: 0,1"),
                $displayNames
            );
        }

        foreach ($answers as $answer) {
            unlink(Config::migrations_path($answer));
            $this->info(asComment(str_replace(".php", "", $answer)) . " deleted successfully.");
        }
    }
}

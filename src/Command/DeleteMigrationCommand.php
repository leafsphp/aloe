<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteMigrationCommand extends Command
{
    protected static $defaultName = 'd:migration';
    public $description = 'Delete a migration';
    public $help = 'Delete a particular migration file';

    protected function config()
    {
        $this->setArgument('file', 'required', 'File to delete');
    }

    protected function handle()
    {
        $fileToDelete = strtolower(Str::snake(Str::plural($this->argument('file'))));
        $migrations = glob(Config::rootpath(MigrationsPath("*_$fileToDelete.php")));

        if (count($migrations) === 0) {
            $this->error("$fileToDelete not found");
            return 1;
        }

        $displayNames = [];
        $answers = [];

        foreach ($migrations as $migration) {
            $displayNames[] = str_replace(Config::rootpath(MigrationsPath()), "", $migration);
        }

        if (count($migrations) === 1) {
            $answers = $displayNames;
        }

        if (count($migrations) > 1) {
            $answers = $this->multiChoice(
                count($migrations) . " '$fileToDelete' found. Select those to delete:" .
                    asInfo(' eg: 0,1'),
                $displayNames
            );
        }

        foreach ($answers as $answer) {
            unlink(Config::rootpath(MigrationsPath($answer)));
            $this->info(asComment(str_replace('.php', '', $answer)) . ' deleted successfully.');
        }

        return 0;
    }
}

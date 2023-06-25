<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateMigrationCommand extends Command
{
    protected static $defaultName = 'g:migration';
    public $description = 'Create a new migration file';
    public $help = 'Create a new migration file';

    protected function config()
    {
        $this->setArgument('migration', 'required', 'migration file name');
        $this->setOption('table', 't', 'optional', 'The database table to work with');
    }

    protected function handle()
    {
        $userInput = strtolower(Str::snake(Str::plural($this->argument('migration'))));
        $fileContent = \file_get_contents(__DIR__ . '/stubs/migration.stub');
        $table = $this->option('table') ?? $userInput;

        if (
            strpos($userInput, 'add_') === 0 ||
            strpos($userInput, 'change_') === 0 ||
            strpos($userInput, 'update_') === 0 ||
            strpos($userInput, 'edit_') === 0
        ) {
            $fileContent = \file_get_contents(__DIR__ . '/stubs/updateMigration.stub');
            $userInput = Str::singular($userInput);
        } else if (strpos($userInput, 'create') === false) {
            $userInput = Str::snake("create_$userInput");
        }

        $actualFileName = Str::snake(date('Y_m_d_His') . "_$userInput.php");
        $file = Config::rootPath(MigrationsPath($actualFileName));

        touch($file);

        $className = Str::studly($userInput);
        $fileContent = str_replace(
            ['ClassName', 'tableName'],
            [$className, str_replace('create_', '', $table)],
            $fileContent
        );

        file_put_contents($file, $fileContent);

        $this->info(asComment($actualFileName) . ' generated successfully');
        return 0;
    }
}

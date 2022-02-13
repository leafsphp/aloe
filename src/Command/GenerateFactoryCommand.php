<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateFactoryCommand extends Command
{
    protected static $defaultName = 'g:factory';
    public $description = 'Create a new model factory';
    public $help = 'Create a new model factory';

    protected function config()
    {
        $this->setArgument('factory', 'required', 'factory name');
    }

    protected function handle()
    {
        $factory = Str::studly(Str::singular($this->argument('factory')));

        if (!strpos($factory, 'Factory')) {
            $factory .= 'Factory';
        }

        $modelName = str_replace('Factory', '', $factory);

        $file = Config::factoriesPath("$factory.php");

        if (file_exists($file)) {
            return $this->error("$factory already exists");
        }

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . '/stubs/factory.stub');
        $fileContent = str_replace(
            ['ClassName', 'ModelName'],
            [$factory, $modelName],
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $this->comment("$factory generated successfully");
    }
}

<?php

namespace Aloe\Command;

use Aloe\Command;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Str;

class GenerateFactoryCommand extends Command
{
    public $name = 'g:factory';
    public $description = 'Create a new model factory';
    public $help = 'Create a new model factory';

    public function config()
    {
        $this->addArgument("factory", InputArgument::REQUIRED, "factory name");
    }

    public function handle()
    {
        $factory = Str::studly(Str::singular($this->argument("factory")));
        $modelName = $factory;
        
        if (!strpos($factory, "Factory")) {
            $factory .= "Factory";
        }

        $file = Config::factories_path("$factory.php");

        if (file_exists($file)) {
            return $this->error("$factory already exists");
        }

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . "/stubs/factory.stub");
        $fileContent = str_replace(
            ["ClassName", "ModelName"],
            [$factory, $modelName],
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $this->comment("$factory generated successfully");
    }
}

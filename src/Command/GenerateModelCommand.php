<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateModelCommand extends Command
{
    public $name = "g:model";
    public $description = "Create a new model class";
    public $help = "Create a new model class";

    public function config()
    {
        $this
            ->addArgument('model', "required", 'model file name')
            ->addOption("migration", "m", "none", 'Create a migration for model');
    }

    public function handle()
    {
        $model = Str::singular(Str::studly($this->argument("model")));
        $file = Config::models_path("$model.php");

        if (!file_exists($model)) {
            return $this->error("Model already exists");
        }

        $model = $this->createModel();
        $this->info(asComment($model) . " model generated");

        if ($this->option('migration')) {
            $migration = Str::snake(Str::plural($model));
            $process = $this->runProcess("php aloe g:model $migration");

            $this->info(
                $process === 0 ?
                    asComment($migration) . " migration generated" :
                    asError("Couldn't generate migration")
            );
        }
    }

    public function createModel(): String
    {
        $model = Str::singular(Str::studly($this->argument("model")));

        $className = $model;

        if (strpos($model, "/") && strpos($model, "/") !== 0) {
            list($dirname, $className) = explode("/", $model);
        }

        $fileContent = \file_get_contents(__DIR__ . '/stubs/model.stub');
        $fileContent = str_replace("ClassName", $className, $fileContent);
        $filePath = Config::models_path("$model.php");

        if (!is_dir(dirname($filePath))) mkdir(dirname($filePath));

        file_put_contents($filePath, $fileContent);

        return $model;
    }
}

<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class GenerateModelCommand extends Command
{
    protected $signature = 'g:model
        {model : The name of the model}
        {--m|migration? : Create a migration for model}';
    protected $description = 'Create a new model class';
    protected $help = 'Create a new model class';

    protected function handle()
    {
        $model = Str::singular(Str::studly($this->argument('model')));
        $className = $model;

        if (strpos($model, '/') && strpos($model, '/') !== 0) {
            list($dirname, $className) = explode('/', $model);
        }

        $file = getcwd() . ModelsPath("$model.php");

        if (file_exists($file)) {
            $this->error('Model already exists');
            return 1;
        }

        \Leaf\FS\File::create($file, function () use ($className) {
            $fileContent = \file_get_contents(__DIR__ . '/stubs/model.stub');
            $fileContent = str_replace('ClassName', $className, $fileContent);

            return $fileContent;
        }, ['recursive' => true]);

        $this->info("<comment>$model</comment> model generated");

        if ($this->option('migration')) {
            $migration = Str::snake(Str::plural($model));
            $process = sprout()->process("php leaf g:migration $migration")->run();

            $this->info(
                $process === 0 ?
                    "<comment>$migration</comment> migration generated" :
                    "<error>Couldn't generate migration</error>"
            );

            return $process;
        }

        return 0;
    }
}

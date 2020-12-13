<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteModelCommand extends Command
{
    public $name = "d:model";
    public $description = "Delete a model";
    public $help = "Delete a model file";

    public function config()
    {
        $this->setArgument("model", "required", "model name");
    }

    public function handle()
    {
        $model = Str::studly($this->argument("model"));
        $file = Config::models_path("$model.php");

        if (!file_exists($file)) {
            return $this->error("$model doesn't exist!");
        }

        unlink($file);
        $this->comment("$model deleted successfully");
    }
}

<?php

namespace Aloe\Command;

use Aloe\Command;
use Leaf\Str;

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

        $dirname = dirname($file);

        unlink($file);
        $this->comment("$model deleted successfully");

        $dir = glob("$dirname/*");

        if ($dirname != Config::models_path() && count($dir) == 0) {
            if ($this->confirm(asError("> " . explode("/", $model)[0] . " is empty. Delete folder?"))) {
                if (rmdir($dirname)) {
                    $this->comment(explode("/", $model)[0] . " deleted successfully!");
                }
            }
        }

    }
}

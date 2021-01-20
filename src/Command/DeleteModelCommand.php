<?php

namespace Aloe\Command;

use Aloe\Command;
use Leaf\Str;

class DeleteModelCommand extends Command
{
    protected static $defaultName = "d:model";
    private $description = "Delete a model";
    private $help = "Delete a model file";

    protected function configure()
    {
        $this->setArgument("model", "required", "model name");
    }

    protected function handle()
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

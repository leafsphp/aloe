<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteModelCommand extends Command
{
    protected static $defaultName = 'd:model';
    public $description = 'Delete a model';
    public $help = 'Delete a model file';

    protected function config()
    {
        $this->setArgument('model', 'required', 'model name');
    }

    protected function handle()
    {
        $model = Str::studly($this->argument('model'));
        $file = Config::rootpath(ModelsPath("$model.php"));

        if (!\Leaf\FS\File::exists($file)) {
            $this->error("$model doesn't exist!");
            return 1;
        }

        if (!\Leaf\FS\File::delete($file)) {
            $this->error("Couldn't delete $file, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$model deleted successfully");

        if (\Leaf\FS\Directory::isEmpty($dirname = dirname($file))) {
            if ($this->confirm(asError("> $dirname is empty. Delete folder?"))) {
                if (\Leaf\FS\Directory::delete($dirname)) {
                    $this->comment("$dirname deleted successfully!");
                }
            }
        }

        return 0;
    }
}

<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteControllerCommand extends Command
{
    protected static $defaultName = 'd:controller';
    public $description = 'Delete a controller';
    public $help = 'Delete a controller';

    protected function config()
    {
        $this->setArgument('controller', 'required', 'controller name');
    }

    protected function handle()
    {
        $controller = Str::studly($this->argument('controller'));

        if (!strpos($controller, 'Controller')) {
            $controller = str::plural($controller);
            $controller .= 'Controller';
        }

        $controllerFile = Config::controllersPath("$controller.php");

        if (!file_exists($controllerFile)) {
            return $this->error("$controller doesn't exist!");
        }

        if (!unlink($controllerFile)) {
            return $this->error("Couldn't delete $controller, you might need to remove it manually.");
        }

        $this->comment("$controller deleted successfully");
    }
}

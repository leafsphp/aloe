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

        $controllerFile = Config::rootpath(ControllersPath("$controller.php"));

        if (!file_exists($controllerFile)) {
            $this->error("$controller doesn't exist!");
            return 1;
        }

        if (!unlink($controllerFile)) {
            $this->error("Couldn't delete $controller, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$controller deleted successfully");
        return 0;
    }
}

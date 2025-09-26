<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class DeleteControllerCommand extends Command
{
    protected $signature = 'd:controller
        {controller : The name of the controller}';
    protected $description = 'Delete a controller';
    protected $help = 'Delete a controller';

    protected function handle()
    {
        $controller = Str::studly($this->argument('controller'));

        if (!strpos($controller, 'Controller')) {
            $controller = str::plural($controller);
            $controller .= 'Controller';
        }

        $controllerFile = getcwd() . ControllersPath("$controller.php");

        if (!\Leaf\FS\File::exists($controllerFile)) {
            $this->error("$controller doesn't exist!");
            return 1;
        }

        if (!\Leaf\FS\File::delete($controllerFile)) {
            $this->error("Couldn't delete $controllerFile, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$controller deleted successfully");

        return 0;
    }
}

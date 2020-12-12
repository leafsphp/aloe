<?php

namespace Aloe\Command;

use Aloe\Command;
use Leaf\Str;
use Symfony\Component\Console\Input\InputArgument;

class DeleteControllerCommand extends Command {

    public $name = "d:controller";
    public $description = 'Delete a controller';
    public $help = 'Delete a controller';

    public function config() {
        $this->addArgument("controller", InputArgument::REQUIRED, "controller name");
    }

    public function handle()
    {
        $controller = Str::studly(Str::plural($this->argument("controller")));

        if (!strpos($controller, "Controller")) {
            $controller .= "Controller";
        }

        $controllerFile = Config::controllers_path("$controller.php");

        if (!file_exists($controllerFile)) {
            return $this->error("$controller doesn't exist!");
        }

        unlink($controllerFile);

        $this->comment("$controller deleted successfully");
    }
}

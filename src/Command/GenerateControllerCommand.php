<?php

namespace Aloe\Command;

use Aloe\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

class GenerateControllerCommand extends Command
{
    public $name = 'g:controller';
    public $description = 'Create a new controller class';
    public $help = 'Create a new controller class';

    public function config()
    {
        $this
            ->addArgument("controller", InputArgument::REQUIRED, 'controller name')
            ->addOption("all", "a", InputOption::VALUE_NONE, 'Create a model and migration for controller')
            ->addOption("model", "m", InputOption::VALUE_NONE, 'Create a model for controller')
            ->addOption("resource", "r", InputOption::VALUE_NONE, 'Create a resource controller')
            ->addOption("api-resource", "ar", InputOption::VALUE_NONE, 'Create an API resource controller')
            ->addOption("web", "w", InputOption::VALUE_NONE, 'Create a web(ordinary) controller')
            ->addOption("api", null, InputOption::VALUE_NONE, 'Create a web(ordinary) controller');
    }

    public function handle()
    {
        $controller = Str::studly(Str::plural($this->argument("controller")));

        if (!strpos($controller, "Controller")) {
            $controller .= "Controller";
        }

        $controllerFile = Config::controllers_path("$controller.php");
        $modelName = Str::singular(Str::studly(
            str_replace("Controller", "", $this->argument("controller"))
        ));

        if (file_exists($controllerFile)) {
            return $this->error("$controller already exists");
        }

        touch($controllerFile);

        $stub = Config::$env === "WEB" ? "controller" : "apiController";

        if ($this->option("resource")) {
            $stub = "resourceController";
        } else if ($this->option("api-resource")) {
            $stub = "apiResourceController";
        } else if ($this->option("web")) {
            $stub = "controller";
        } else if ($this->option("api")) {
            $stub = "apiController";
        }

        $fileContent = file_get_contents(__DIR__ . "/stubs/$stub.stub");
        $fileContent = str_replace(
            ["ClassName", "ModelName"],
            [$controller, $modelName],
            $fileContent
        );
        file_put_contents($controllerFile, $fileContent);

        $this->comment("$controller created successfully");

        if ($this->option("all")) {
            $process = $this->runProcess("php aloe g:model $modelName -m");
            $this->comment(
                $process === 0 ?
                    "Model & Migration generated successfully!" :
                    asError("Couldn't generate files")
            );
        } else if ($this->option("model")) {
            $process = $this->runProcess("php aloe g:model $modelName");
            $this->comment(
                $process === 0 ?
                    "Model generated successfully!" :
                    asError("Couldn't generate model")
            );
        }
    }
}

<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateControllerCommand extends Command
{
    public $name = 'g:controller';
    public $description = 'Create a new controller class';
    public $help = 'Create a new controller class';

    public function config()
    {
        $this
            ->setArgument("controller", "required", 'controller name')
            ->setOption("all", "a", "none", 'Create a model and migration for controller')
            ->setOption("model", "m", "none", 'Create a model for controller')
            ->setOption("resource", "r", "none", 'Create a resource controller')
            ->setOption("api-resource", "ar", "none", 'Create an API resource controller')
            ->setOption("web", "w", "none", 'Create a web(ordinary) controller')
            ->setOption("api", null, "none", 'Create a web(ordinary) controller');
    }

    public function handle()
    {
        $controller = Str::studly($this->argument("controller"));

        if (!strpos($controller, "Controller")) {
            $controller = str::plural($controller);
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

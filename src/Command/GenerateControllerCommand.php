<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class GenerateControllerCommand extends Command
{
    protected $signature = 'g:controller
        {controller : The name of the controller}
        {--a|all? : Create a model and migration for controller}
        {--m|model? : Create a model for controller}
        {--t|template? : Create a template for controller}
        {--r|resource? : Create a resource controller}
        {--ar|api-resource? : Create an API resource controller}
        {--wr|web-resource? : Create a web resource controller}
        {--w|web? : Create a web(ordinary) controller}
        {--api? : Create an API controller}';
    protected $description = 'Create a new controller class';
    protected $help = 'Create a new controller class';

    protected function handle()
    {
        $controller = Str::studly($this->argument('controller'));

        if (!strpos($controller, 'Controller')) {
            $controller = str::plural($controller);
            $controller .= 'Controller';
        }

        $controllerFile = getcwd() . ControllersPath("$controller.php");

        $modelName = Str::singular(Str::studly(
            str_replace('Controller', '', basename($this->argument('controller')))
        ));

        if (file_exists($controllerFile)) {
            $this->error("$controller already exists");
            return 1;
        }

        $this->generateController($controllerFile, $controller, $modelName);

        return $this->generateExtraFiles($modelName);
    }

    protected function generateController($controllerFile, $controller, $modelName)
    {
        $stub = \Leaf\Core::mode() === 'web' ? 'controller' : 'apiController';

        if ($this->option('resource')) {
            $stub = \Leaf\Core::mode() === 'web' ? 'resourceController' : 'apiResourceController';
        } elseif ($this->option('web-resource')) {
            $stub = 'resourceController';
        } elseif ($this->option('api-resource')) {
            $stub = 'apiResourceController';
        } elseif ($this->option('web')) {
            $stub = 'controller';
        } elseif ($this->option('api')) {
            $stub = 'apiController';
        }

        \Leaf\FS\File::create($controllerFile, function () use ($stub, $controller, $modelName) {
            $className = basename($controller);
            $viewRender = 'response()->render(';

            if (\Leaf\FS\File::exists(getcwd() . '/app/views/_inertia.blade.php')) {
                $viewRender = 'response()->inertia(';
            }

            $fileContent = file_get_contents(__DIR__ . "/stubs/$stub.stub");
            $fileContent = str_replace(
                ['ClassName', 'ModelName', 'viewFile', 'render('],
                [$className, $modelName, Str::singular(strtolower(str_replace('Controller', '', $controller))), $viewRender],
                $fileContent
            );

            return $fileContent;
        }, ['recursive' => true]);

        $this->comment("$controller created successfully");

        return 0;
    }

    protected function generateExtraFiles($modelName)
    {
        if ($this->option('all')) {
            $process = sprout()->process("php leaf g:model $modelName -m")->run();

            $this->comment(
                $process === 0 ?
                'Model & Migration generated successfully!' :
                '<error>Couldn\'t generate files</error>'
            );

            if (\Leaf\Core::mode() === 'web') {
                $process = sprout()->process("php leaf g:template $modelName")->run();

                $this->comment(
                    $process === 0 ?
                    'Template generated successfully!' :
                    '<error>Couldn\'t generate template</error>'
                );
            }

            return $process;
        } else {
            if ($this->option('model')) {
                $process = sprout()->process("php leaf g:model $modelName")->run();

                $this->comment(
                    $process === 0 ?
                    'Model generated successfully!' :
                    '<error>Couldn\'t generate model</error>'
                );

                return $process;
            }

            if ($this->option('template')) {
                $process = sprout()->process("php leaf g:template $modelName")->run();

                $this->comment(
                    $process === 0 ?
                    'Template generated successfully!' :
                    '<error>Couldn\'t generate template</error>'
                );

                return $process;
            }
        }
    }
}

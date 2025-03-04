<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateControllerCommand extends Command
{
    protected static $defaultName = 'g:controller';
    public $description = 'Create a new controller class';
    public $help = 'Create a new controller class';

    protected function config()
    {
        $this
            ->setArgument('controller', 'required', 'controller name')
            ->setOption('all', 'a', 'none', 'Create a model and migration for controller')
            ->setOption('model', 'm', 'none', 'Create a model for controller')
            ->setOption('template', 't', 'none', 'Create a template for controller')
            ->setOption('resource', 'r', 'none', 'Create a resource controller')
            ->setOption('api-resource', 'ar', 'none', 'Create an API resource controller')
            ->setOption('web-resource', 'wr', 'none', 'Create a web resource controller')
            ->setOption('web', 'w', 'none', 'Create a web(ordinary) controller')
            ->setOption('api', null, 'none', 'Create an API controller');
    }

    protected function handle()
    {
        $controller = Str::studly($this->argument('controller'));

        if (!strpos($controller, 'Controller')) {
            $controller = str::plural($controller);
            $controller .= 'Controller';
        }

        $controllerFile = Config::rootpath(ControllersPath("$controller.php"));
        $modelName = Str::singular(Str::studly(
            str_replace('Controller', '', basename($this->argument('controller')))
        ));

        if (file_exists($controllerFile)) {
            $this->error("$controller already exists");
            return 1;
        }

        $this->generateController($controllerFile, $controller, $modelName);

        $this->generateExtraFiles($modelName);

        return 0;
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

            if (\Leaf\FS\File::exists(Config::rootpath("/app/views/_inertia.blade.php"))) {
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
            $process = $this->runProcess(['php', 'leaf', 'g:model', $modelName, '-m']);
            $this->comment(
                $process === 0 ?
                'Model & Migration generated successfully!' :
                asError('Couldn\'t generate files')
            );

            if (Config::$env === 'WEB') {
                $process = $this->runProcess(['php', 'leaf', 'g:template', $modelName]);
                $this->comment(
                    $process === 0 ?
                    'Template generated successfully!' :
                    asError('Couldn\'t generate template')
                );
            }

            return $process;
        } else {
            if ($this->option('model')) {
                $process = $this->runProcess(['php', 'leaf', 'g:model', $modelName]);
                $this->comment(
                    $process === 0 ?
                    'Model generated successfully!' :
                    asError('Couldn\'t generate model')
                );

                return $process;
            }

            if ($this->option('template')) {
                $process = $this->runProcess(['php', 'leaf', 'g:template', $modelName]);
                $this->comment(
                    $process === 0 ?
                    'Template generated successfully!' :
                    asError('Couldn\'t generate template')
                );

                return $process;
            }
        }
    }
}

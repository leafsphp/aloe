<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateRouteCommand extends Command
{
    protected static $defaultName = 'g:route';
    public $description = 'Create a new route partial';
    public $help = 'Create a new route partial file in the routes directory';

    protected function config()
    {
        $this->setArgument('routeName', 'required', 'route name')
            ->setOption('controller', 'c', 'none', 'Create a controller for route');
    }

    protected function handle()
    {
        $routeName = Str::lower(Str::kebab(ltrim($this->argument('routeName'), '_')));
        $file = Config::rootpath(RoutesPath("_$routeName.php"));
        $controller = Str::pascal($routeName) . 'Controller';

        if (file_exists($file)) {
            $this->error("$routeName already exists!");
            return 1;
        }

        \Leaf\FS\File::create($file, function () use ($routeName, $controller) {
            return str_replace(
                ['route-name', 'routeName'],
                [$routeName, $controller],
                \file_get_contents(__DIR__ . '/stubs/route.stub')
            );
        }, ['recursive' => true]);

        $this->comment("$routeName route generated successfully");

        if ($this->option('controller')) {
            $process = $this->runProcess(['php', 'leaf', 'g:controller', $controller]);

            $this->comment(
                $process === 0 ?
                "$controller generated successfully!" :
                asError('Couldn\'t generate controller')
            );
        }

        return 0;
    }
}

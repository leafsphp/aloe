<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class GenerateRouteCommand extends Command
{
    protected $signature = 'g:route
        {routeName : The name of the route}
        {--c|controller? : Create a controller for route}';
    protected $description = 'Create a new route partial';
    protected $help = 'Create a new route partial file in the routes directory';

    protected function handle()
    {
        $routeName = Str::lower(Str::kebab(ltrim($this->argument('routeName'), '_')));
        $routeFile = getcwd() . RoutesPath("_$routeName.php");
        $controller = Str::pascal($routeName) . 'Controller';

        if (file_exists($routeFile)) {
            $this->error("$routeName already exists!");
            return 1;
        }

        \Leaf\FS\File::create($routeFile, function () use ($routeName, $controller) {
            return str_replace(
                ['route-name', 'routeName'],
                [$routeName, $controller],
                \file_get_contents(__DIR__ . '/stubs/route.stub')
            );
        }, ['recursive' => true]);

        $this->comment("$routeName route generated successfully");

        if ($this->option('controller')) {
            $process = sprout()->process("php leaf g:controller $controller")->run();

            $this->comment(
                $process === 0 ?
                "$controller generated successfully!" :
                "<error>Couldn't generate controller</error>"
            );
        }

        return 0;
    }
}

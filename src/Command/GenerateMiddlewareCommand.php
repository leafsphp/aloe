<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class GenerateMiddlewareCommand extends Command
{
    protected $signature = 'g:middleware {middleware : The name of the middleware}';
    protected $description = 'Create a new application middleware';
    protected $help = 'Create a new application middleware';

    protected function handle()
    {
        $middleware = Str::studly(Str::singular($this->argument('middleware')));

        if (!strpos($middleware, 'Middleware')) {
            $middleware .= 'Middleware';
        }

        $middlewareFile = getcwd() . AppPaths('middleware') . "/$middleware.php";

        if (file_exists($middlewareFile)) {
            $this->error("$middleware already exists");
            return 1;
        }

        \Leaf\FS\File::create($middlewareFile, function () use ($middleware) {
            $fileContent = \file_get_contents(__DIR__ . '/stubs/middleware.stub');
            $fileContent = str_replace(
                'ClassName',
                $middleware,
                $fileContent
            );

            return $fileContent;
        }, ['recursive' => true]);

        $this->comment("$middleware generated successfully");

        return 0;
    }
}

<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateMiddlewareCommand extends Command
{
    protected static $defaultName = 'g:middleware';
    public $description = 'Create a new application middleware';
    public $help = 'Create a new application middleware';

    protected function config()
    {
        $this->setArgument('middleware', 'required', 'middleware name');
    }

    protected function handle()
    {
        $middleware = Str::studly(Str::singular($this->argument('middleware')));

        if (!strpos($middleware, 'Middleware')) {
            $middleware .= 'Middleware';
        }

        $file = Config::rootpath(AppPaths('middleware') . "/$middleware.php");

        if (file_exists($file)) {
            $this->error("$middleware already exists");
            return 1;
        }

        \Leaf\FS\File::create($file, function () use ($middleware) {
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

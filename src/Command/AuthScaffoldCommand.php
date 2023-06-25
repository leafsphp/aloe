<?php

namespace Aloe\Command;

use Aloe\Installer;
use Leaf\FS;
use Illuminate\Support\Str;

class AuthScaffoldCommand extends \Aloe\Command
{
    protected static $defaultName = 'auth:scaffold';
    public $description = 'Scaffold basic app authentication';
    public $help = 'Create basic views, routes and controllers for authentication';

    protected function config()
    {
        $this
            ->setOption('session', 's', 'NONE', 'Use session/session + JWT instead of just JWT')
            ->setOption('api', 'a', 'NONE', 'Use JWT for authentication');
    }

    protected function handle()
    {
        $driver = 'session';

        if ($this->option('api')) {
            $driver = 'api';
        }

        if (Config::$env === 'API' && !$this->option('session')) {
            $driver = 'api';
        }

        $installablesDir = $this->installable($driver);

        Installer::magicCopy($installablesDir);
        Installer::installRoutes("$installablesDir/app/routes/");

        $this->info('Authentication generated successfully.');

        return 0;
    }

    protected function installable($driver)
    {
        return dirname(__DIR__) . '/Scaffold/' .  Str::studly($driver . 'Auth');
    }
}

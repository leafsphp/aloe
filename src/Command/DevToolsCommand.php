<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class DevToolsCommand extends Command
{
    protected $signature = 'devtools:install';
    protected $description = 'Install the Leaf PHP devtools';
    protected $help = 'Install the leaf PHP Dev tools';

    protected function handle()
    {
        $this->comment('Installing leaf devtools...');

        if (sprout()->composer()->install('leafs/devtools')->getExitCode() !== 0) {
            $this->error('Failed to install leaf devtools via composer. Please run "composer require leafs/devtools" manually.');
            return 1;
        }

        $this->comment('Installing leaf devtools routes...');

        $rootFilePath = getcwd() . PublicPath('index.php');
        $rootFile = str_replace(
            "/*
|--------------------------------------------------------------------------
| Install the devtools
|--------------------------------------------------------------------------
|
| Add Leaf devtools routes and config
|
*/
\Leaf\DevTools::install();",
            '',
            \Leaf\FS\File::read($rootFilePath)
        );

        $rootFile = str_replace(
            ["require dirname(__DIR__) . '/vendor/autoload.php';", 'require "$appPath/vendor/autoload.php"'],
            "require dirname(__DIR__) . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Install the devtools
|--------------------------------------------------------------------------
|
| Add Leaf devtools routes and config
|
*/
\Leaf\DevTools::install();",
            $rootFile
        );

        $rootFile = str_replace("\n\n\n", "\n", $rootFile);

        \Leaf\FS\File::write($rootFilePath, $rootFile);

        $this->info('Leaf devtools installed successfully!');

        return 0;
    }
}

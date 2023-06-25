<?php

namespace Aloe\Command;

use Aloe\Installer;
use Leaf\FS;

class DevToolsCommand extends \Aloe\Command
{
    protected static $defaultName = 'devtools:install';
    public $description = 'Install the Leaf PHP devtools';
    public $help = 'Install the leaf PHP Dev tools';

    protected function handle()
    {
        $this->comment('Installing leaf devtools...');
        Installer::installPackages('devtools');

        $this->comment('Installing leaf devtools routes...');

        $rootFile = FS::readFile(Config::rootPath(PublicPath('index.php')));
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
            "",
            $rootFile
        );

        $rootFile = str_replace(
            "require dirname(__DIR__) . '/vendor/autoload.php';",
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

        FS::writeFile(Config::rootPath(PublicPath('index.php')), $rootFile);

        $this->info('Leaf devtools installed successfully!');

        return 0;
    }
}

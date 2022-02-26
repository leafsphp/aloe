<?php

namespace Aloe\Command;

use Aloe\Installer;

class InstallDebuggerCommand extends \Aloe\Command
{
    protected static $defaultName = 'install:debugger';
    public $description = 'Install the leaf app debugger';
    public $help = 'Install the leaf debug tool';

    protected function handle()
    {
        $installablesDir = dirname(__DIR__) . '/Scaffold/Debugger';

        Installer::magicCopy($installablesDir);
        Installer::installRoutes("$installablesDir/routes/");

        $this->info('Debugger installed successfully.');
    }
}

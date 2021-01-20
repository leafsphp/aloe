<?php

namespace Aloe\Command;

use Aloe\Installer;
use Leaf\FS;

class InstallDebuggerCommand extends \Aloe\Command
{
    protected static $defaultName = "install:debugger";
    private $description = "Install the leaf app debugger";
    private $help = "Install the leaf debug tool";

    protected function handle()
    {
        $installablesDir = dirname(__DIR__) . "/Scaffold/Debugger";

        Installer::magicCopy($installablesDir);
        Installer::installRoutes("$installablesDir/Routes/");

        $this->info("Debugger installed successfully.");
    }
}

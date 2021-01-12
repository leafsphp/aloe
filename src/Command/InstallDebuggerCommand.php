<?php

namespace Aloe\Command;

use Aloe\Installer;
use Leaf\FS;

class InstallDebuggerCommand extends \Aloe\Command
{
    public $name = "install:debugger";
    public $description = "Install the leaf app debugger";
    public $help = "Install the leaf debug tool";

    public function handle()
    {
        $installablesDir = dirname(__DIR__) . "/Scaffold/Debugger";

        Installer::magicCopy($installablesDir);
        Installer::installRoutes("$installablesDir/Routes/");

        $this->info("Debugger installed successfully.");
    }
}

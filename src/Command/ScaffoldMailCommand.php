<?php

namespace Aloe\Command;

use Aloe\Installer;

class ScaffoldMailCommand extends \Aloe\Command
{
    protected static $defaultName = 'scaffold:mail';
    public $description = 'Install leaf mail and setup mail config';
    public $help = 'Install leaf mail and setup mail config';

    protected function handle()
    {
        $this->comment('Installing leaf mail...');
        Installer::installPackages('mail');

        $this->comment('Setting up leaf mail...');
        Installer::magicCopy(dirname(__DIR__) . '/themes/mail');

        $this->info('Leaf mail installed successfully!');

        return 0;
    }
}

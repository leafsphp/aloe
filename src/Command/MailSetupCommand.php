<?php

namespace Aloe\Command;

use Aloe\Installer;
use Leaf\FS;

class MailSetupCommand extends \Aloe\Command
{
    protected static $defaultName = 'mail:setup';
    public $description = 'Install leaf mail and setup mail config';
    public $help = 'Install leaf mail and setup mail config';

    protected function handle()
    {
        $this->comment('Installing leaf mail...');
        Installer::installPackages('mail');

        $this->comment('Setting up leaf mail...');
        Installer::magicCopy(dirname(__DIR__) . '/Scaffold/Mail');

        $this->info('Leaf mail installed successfully!');

        return 0;
    }
}

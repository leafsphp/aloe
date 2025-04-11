<?php

namespace Aloe\Command;

use Aloe\Installer;

class ScaffoldShadcnCommand extends \Aloe\Command
{
    protected static $defaultName = 'scaffold:shadcn';
    public $description = 'Scaffold shadcn/ui for your react app';
    public $help = 'Create support files for shadcn/ui in your react inertia app';

    protected function handle()
    {
        $this->comment("Scaffolding Shadcn support files...");

        Installer::magicCopy(__DIR__ . '/themes/shadcn');

        $this->info('Shadcn files generated successfully.');

        return 0;
    }
}

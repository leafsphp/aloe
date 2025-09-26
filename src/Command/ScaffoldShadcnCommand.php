<?php

namespace Aloe\Command;

use Aloe\Installer;
use Leaf\Sprout\Command;

class ScaffoldShadcnCommand extends Command
{
    protected $signature = 'scaffold:shadcn';
    protected $description = 'Scaffold shadcn/ui for your react app';
    protected $help = 'Create support files for shadcn/ui in your react inertia app';

    protected function handle()
    {
        $this->comment("Scaffolding Shadcn support files...");

        Installer::magicCopy(__DIR__ . '/themes/shadcn');

        $this->info('Shadcn files generated successfully.');

        return 0;
    }
}

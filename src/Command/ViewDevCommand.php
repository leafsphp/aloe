<?php

declare(strict_types=1);

namespace Aloe\Command;

use Leaf\Sprout\Command;

class ViewDevCommand extends Command
{
    protected $signature = 'view:dev';
    protected $description = 'Run your frontend dev command';
    protected $help = 'Run your frontend dev server';
    protected $aliases = ['view:serve'];

    protected function handle()
    {
        if (!is_dir(getcwd() . '/node_modules')) {
            $this->writeln('<info>Installing dependencies...</info>');

            if (!sprout()->npm()->install()) {
                $this->writeln('<error>❌  Failed to install dependencies.</error>');
                return 1;
            }
        }

        return sprout()->npm()->runScript('dev')->getExitCode();
    }
}

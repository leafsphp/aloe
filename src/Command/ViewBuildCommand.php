<?php

declare(strict_types=1);

namespace Aloe\Command;

use Leaf\Sprout\Command;

class ViewBuildCommand extends Command
{
    protected $signature = 'view:build';
    protected $description = 'Run your frontend build command';
    protected $help = 'Run your frontend build server';

    protected function handle()
    {
        if (!is_dir(getcwd() . '/node_modules')) {
            $this->writeln('<info>Installing dependencies...</info>');

            if (!sprout()->npm()->install()) {
                $this->writeln('<error>❌  Failed to install dependencies.</error>');
                return 1;
            }
        }

        return sprout()->npm()->runScript('build')->getExitCode();
    }
}

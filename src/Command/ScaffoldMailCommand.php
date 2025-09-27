<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class ScaffoldMailCommand extends Command
{
    protected $signature = 'scaffold:mail';
    protected $description = 'Install leaf mail and setup mail config';
    protected $help = 'Install leaf mail and setup mail config';

    protected function handle()
    {
        $this->comment('Installing leaf mail...');

        sprout()->composer()->install('leafs/mail');

        $this->comment('Setting up leaf mail...');

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/mail',
            getcwd(),
            ['recursive' => true]
        );

        $this->info('Leaf mail installed successfully!');

        return 0;
    }
}

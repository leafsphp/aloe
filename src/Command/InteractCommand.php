<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Psy\Shell;

class InteractCommand extends Command
{
    protected $signature = 'interact';
    protected $description = 'Interact with your application';
    protected $help = 'Interact with your application';

    protected function handle()
    {
        $shell = new Shell();
        $this->writeln($shell->run());

        return 0;
    }
}

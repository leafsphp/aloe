<?php

namespace Aloe\Command;

use Psy\Shell;

class ConsoleCommand extends \Aloe\Command
{
    protected static $defaultName = "interact";
    private $description = "Interact with your application";
    private $help = "Interact with your application";

    protected function handle()
    {
        $shell = new Shell();
        $this->writeln($shell->run());
    }
}

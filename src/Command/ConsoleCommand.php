<?php

namespace Aloe\Command;

use Psy\Shell;

class ConsoleCommand extends \Aloe\Command
{
    public $name = "interact";
    public $description = "Interact with your application";
    public $help = "Interact with your application";

    public function handle() {
        $shell = new Shell();
        $this->writeln($shell->run());
    }
}

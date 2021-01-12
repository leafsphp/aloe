<?php

namespace Aloe\Command;

use Aloe\Command;

class ServeCommand extends Command
{
    public $name = "serve";
    public $description = "Start the leaf development server";
    public $help = "Run your Leaf app on PHP's local development server";

    public function config()
    {
        $this->setOption("port", "p", "optional", "Port to run Leaf app on", 5500);
        $this->setArgument("path", "optional", "Path to your app (in case you changed it)");
    }

    public function handle()
    {
        $port = $this->option("port");
        $path = $this->argument("path");

        $this->writeln("Server started on " . asComment("http://localhost:$port"));
        $this->info("Happy gardening!!\n");
        $this->writeln(shell_exec("php -S localhost:$port $path"));
    }
}

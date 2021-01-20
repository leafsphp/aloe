<?php

namespace Aloe\Command;

use Aloe\Command;
use Leaf\Str;

class DeleteConsoleCommand extends Command
{
    public $name = "d:command";
    public $description = "Delete a console command";
    public $help = "Delete a console command";

    public function config()
    {
        $this->setArgument("file", "required", "The name of the console file");
    }

    public function handle()
    {
        $command = Str::studly($this->argument("file"));

        if (!strpos($command, "Command")) {
            $command .= "Command";
        }

        $file = Config::commands_path("$command.php");

        if (!file_exists($file)) {
            return $this->error("$command doesn't exist!");
        }

        if (!unlink($file)) {
            return $this->error("Couldn't delete $command, you might need to remove it manually.");
        }

        $this->comment("$command deleted successfully");

        $aloe = Config::rootpath("leaf");
        $aloeContents = file_get_contents($aloe);
        $aloeContents = str_replace(
            "\$console->register(\App\Console\\$command::class);
",
            "",
            $aloeContents
        );
        \file_put_contents($aloe, $aloeContents);

        $this->comment("$command command unregistered");
    }
}
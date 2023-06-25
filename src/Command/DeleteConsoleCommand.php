<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteConsoleCommand extends Command
{
    protected static $defaultName = 'd:command';
    public $description = 'Delete a console command';
    public $help = 'Delete a console command';

    protected function config()
    {
        $this->setArgument('file', 'required', 'The name of the console file');
    }

    protected function handle()
    {
        $command = Str::studly($this->argument('file'));

        if (!strpos($command, 'Command')) {
            $command .= 'Command';
        }

        $file = Config::rootpath(CommandsPath("$command.php"));

        if (!file_exists($file)) {
            $this->error("$command doesn't exist!");
            return 1;
        }

        if (!unlink($file)) {
            $this->error("Couldn't delete $command, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$command deleted successfully");

        $aloe = Config::rootpath('leaf');
        $aloeContents = file_get_contents($aloe);
        $search = "\$console->register(\App\Console\\$command::class);";
        $aloeContents = str_replace(["$search\n", $search], '', $aloeContents);
        \file_put_contents($aloe, $aloeContents);

        $this->comment("$command command unregistered");
        return 0;
    }
}

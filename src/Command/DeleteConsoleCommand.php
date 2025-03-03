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

        if (!\Leaf\FS\File::exists($file)) {
            $this->error("$command doesn't exist!");
            return 1;
        }

        if (!\Leaf\FS\File::delete($file)) {
            $this->error("Couldn't delete $command, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$command deleted successfully");

        return 0;
    }
}

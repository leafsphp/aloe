<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class DeleteConsoleCommand extends Command
{
    protected $signature = 'd:command
        {file : The name of the console file}';
    protected $description = 'Delete a console command';
    protected $help = 'Delete a console command';

    protected function handle()
    {
        $command = Str::studly($this->argument('file'));

        if (!strpos($command, 'Command')) {
            $command .= 'Command';
        }

        $file = getcwd() . CommandsPath("$command.php");

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

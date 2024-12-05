<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateConsoleCommand extends Command
{
    protected static $defaultName = 'g:command';
    public $description = 'Create a new console command';
    public $help = 'Create a custom aloe cli command';

    protected function config()
    {
        $this->setArgument('consoleCommand', 'required', 'command name');
    }

    protected function handle()
    {
        list($commandName, $className) = $this->mapNames($this->argument('consoleCommand'));

        $file = Config::rootpath(CommandsPath("$className.php"));

        if (file_exists($file)) {
            $this->error("$className already exists!");
            return 1;
        }

        if (file_exists(Config::rootpath(CommandsPath('.gitkeep')))) {
            unlink(Config::rootpath(CommandsPath('.gitkeep')));
        }

        \Leaf\FS\File::create($file, function () use ($className, $commandName) {
            return str_replace(
                ['ClassName', 'CommandName'],
                [$className, $commandName],
                \file_get_contents(__DIR__ . '/stubs/console.stub')
            );
        }, ['recursive' => true]);

        $this->comment("$className generated successfully");

        return 0;
    }

    public function mapNames($command)
    {
        $className = $command;

        if (strpos($command, ':')) {
            $commandItems = explode(':', $command);
            $items = [];

            foreach ($commandItems as $item) {
                $items[] = Str::studly($item);
            }

            $className = implode('', $items);
        }

        if (!strpos($className, 'Command')) {
            $className .= 'Command';
        } else {
            $command = str_replace('Command', '', $command);
        }

        return [Str::lower($command), Str::studly($className)];
    }
}

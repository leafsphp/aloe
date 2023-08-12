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

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . '/stubs/console.stub');
        $fileContent = str_replace(['ClassName', 'CommandName'], [$className, $commandName], $fileContent);
        \file_put_contents($file, $fileContent);

        $this->comment("$className generated successfully");

        $aloe = Config::rootpath('leaf');
        $aloeContents = file_get_contents($aloe);
        $replace = "\$console->register(\App\Console\\$className::class);\n\$console->register(";
        $aloeContents = preg_replace('/\$console->register\(/m', $replace, $aloeContents, 1);
        \file_put_contents($aloe, $aloeContents);

        $this->comment("$className registered successfully");

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

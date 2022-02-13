<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteFactoryCommand extends Command
{
    protected static $defaultName = 'd:factory';
    public $description = 'Delete a model factory';
    public $help = 'Delete a model factory';

    protected function config()
    {
        $this->setArgument('factory', 'required', 'factory name');
    }

    protected function handle()
    {
        $factory = Str::studly(Str::singular($this->argument('factory')));

        if (!strpos($factory, 'Factory')) {
            $factory .= 'Factory';
        }

        $file = Config::factoriesPath("$factory.php");

        if (!file_exists($file)) {
            return $this->error("$factory doesn't exists");
        }

        unlink($file);

        $this->comment("$factory deleted successfully");
    }
}

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

        $file = Config::rootpath(FactoriesPath("$factory.php"));

        if (!file_exists($file)) {
            $this->error("$factory doesn't exists");
            return 1;
        }

        unlink($file);

        $this->comment("$factory deleted successfully");
        return 0;
    }
}

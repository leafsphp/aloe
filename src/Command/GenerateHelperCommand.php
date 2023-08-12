<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateHelperCommand extends Command
{
    protected static $defaultName = 'g:helper';
    public $description = 'Create a new helper class';
    public $help = 'Create a new helper class';

    protected function config()
    {
        $this->setArgument('helper', 'required', 'helper name');
    }

    protected function handle()
    {
        list($helper, $modelName) = $this->mapNames($this->argument('helper'));

        $file = Config::rootpath(HelpersPath("$helper.php"));

        if (file_exists($file)) {
            return $this->error("$helper already exists!");
        }

        if (file_exists(Config::rootpath(HelpersPath('.gitkeep')))) {
            unlink(Config::rootpath(HelpersPath('.gitkeep')));
        }

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . '/stubs/helper.stub');
        $fileContent = str_replace(['ClassName', 'ModelName'], [$helper, $modelName], $fileContent);
        \file_put_contents($file, $fileContent);

        return $this->comment("$helper generated successfully");
    }

    public function mapNames($helperName)
    {
        $modelName = $helperName;

        if (!strpos($helperName, 'Helper')) {
            $helperName .= 'Helper';
        } else {
            $modelName = str_replace('Helper', '', $modelName);
        }

        return [Str::studly($helperName), Str::studly(Str::singular($modelName))];
    }
}

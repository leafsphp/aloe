<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class GenerateHelperCommand extends Command
{
    protected static $defaultName = 'g:helper
        {helper : The name of the helper}';
    protected $description = 'Create a new helper class';
    protected $help = 'Create a new helper class';

    protected function handle()
    {
        list($helper, $modelName) = $this->mapNames($this->argument('helper'));

        $helperFile = getcwd() . HelpersPath("$helper.php");

        if (file_exists($helperFile)) {
            return $this->error("$helper already exists!");
        }

        \Leaf\FS\File::create($helperFile, function () use ($helper, $modelName) {
            $fileContent = \file_get_contents(__DIR__ . '/stubs/helper.stub');
            $fileContent = str_replace(['ClassName', 'ModelName'], [$helper, $modelName], $fileContent);

            return $fileContent;
        }, ['recursive' => true]);

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

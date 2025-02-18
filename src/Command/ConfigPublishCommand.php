<?php

namespace Aloe\Command;

use Aloe\Command;

class ConfigPublishCommand extends Command
{
    protected static $defaultName = 'config:publish';
    public $description = 'Publish config files to your project';
    public $help = 'Publish config files to your project';

    protected function config()
    {
        $this->setArgument('config', 'OPTIONAL', 'Config file to publish');
    }

    protected function handle()
    {
        if (!\Leaf\FS\Directory::exists(ConfigPath())) {
            \Leaf\FS\Directory::create(ConfigPath());
        }

        $config = $this->argument('config');
        $configFiles = \Leaf\FS\Directory::files(__DIR__ . '/stubs/config');

        foreach ($configFiles as $file) {
            if ($config && $file !== "$config.php") {
                continue;
            }

            \Leaf\FS\File::copy(
                __DIR__ . "/stubs/config/$file",
                ConfigPath($file),
                ['recursive' => true, 'overwrite' => true]
            );
        }

        $this->comment('Config published successfully!');

        return 0;
    }
}

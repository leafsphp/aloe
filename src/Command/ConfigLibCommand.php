<?php

namespace Aloe\Command;

use Aloe\Command;

class ConfigLibCommand extends Command
{
    protected static $defaultName = 'config:lib';
    public $description = 'Setup Leaf MVC to use external libraries';
    public $help = 'Setup Leaf MVC to use external libraries';

    protected function handle()
    {
        if (!\Leaf\FS\Directory::exists(LibPath())) {
            \Leaf\FS\Directory::create(LibPath());
        }

        $this->comment('lib folder setup successfully!');

        return 0;
    }
}

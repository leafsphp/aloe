<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class ConfigLibCommand extends Command
{
    protected $signature = 'config:lib';
    protected $description = 'Setup Leaf MVC to use external libraries';
    protected $help = 'Setup Leaf MVC to use external libraries';

    protected function handle()
    {
        if (!\Leaf\FS\Directory::exists(LibPath())) {
            \Leaf\FS\Directory::create(LibPath());
        }

        $this->comment('lib folder setup successfully!');

        return 0;
    }
}

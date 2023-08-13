<?php

namespace Aloe\Command;

use Aloe\Command;

class EnvGenerateCommand extends Command
{
    protected static $defaultName = 'env:generate';
    public $description = 'Generate .env file';
    public $help = 'Generate .env file';

    protected function handle()
    {
        if (file_exists(Config::rootpath('.env'))) {
            $this->error('.env already exists');
            return 1;
        }

        if (file_exists(Config::rootpath('.env.example'))) {
            if (copy(Config::rootpath('.env.example'), Config::rootpath('.env')) || copy(__DIR__ . '/stubs/.env.stub', Config::rootpath('.env'))) {
                $this->comment('.env generated successfully!');
                return 0;
            }
        }

        $this->error('Couldn\'t generate env file');
        return 1;
    }
}

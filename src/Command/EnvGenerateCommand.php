<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class EnvGenerateCommand extends Command
{
    protected $signature = 'env:generate';
    protected $description = 'Generate .env file';
    protected $help = 'Generate .env file';

    protected function handle()
    {
        $envFile = getcwd() . '/.env';
        $envExampleFile = getcwd() . '/.env.example';

        if (file_exists($envFile)) {
            $this->error('.env already exists');
            return 1;
        }

        if (file_exists($envExampleFile)) {
            if (\Leaf\FS\File::copy($envExampleFile, $envFile) || \Leaf\FS\File::copy(__DIR__ . '/stubs/.env.stub', $envFile)) {
                $this->comment('.env generated successfully!');
                return 0;
            }
        }

        $this->error('Couldn\'t generate env file');

        return 1;
    }
}

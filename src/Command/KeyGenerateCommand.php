<?php

declare(strict_types=1);

namespace Aloe\Command;

use Leaf\Sprout\Command;

class KeyGenerateCommand extends Command
{
    protected $signature = 'key:generate';
    protected $description = 'Generate/Regenerate your app key';
    protected $help = 'Generate/Regenerate your app key';

    protected function generateKey()
    {
        return 'base64:' . base64_encode(\random_bytes(32));
    }

    protected function handle(): int
    {
        \Leaf\FS\File::write(getcwd() . '/.env', function ($env) {
            if (strpos($env, 'APP_KEY') !== false) {
                $this->info('APP_KEY already exists. Regenerating APP_KEY');
                $env = preg_replace('/APP_KEY=(.*)/', "APP_KEY={$this->generateKey()}", $env);
            } else {
                $env = "APP_KEY={$this->generateKey()}\n$env";
            }

            return $env;
        });

        $this->info('APP_KEY generated successfully.');

        return 0;
    }
}

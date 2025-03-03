<?php

declare(strict_types=1);

namespace Aloe\Command;

class KeyGenerateCommand extends \Aloe\Command
{
    protected static $defaultName = 'key:generate';

    protected function configure()
    {
        $this
            ->setHelp('Generate/Regenerate your app key')
            ->setDescription('Generate/Regenerate your app key');
    }

    protected function generateKey()
    {
        return 'base64:' . base64_encode(\random_bytes(32));
    }

    protected function handle(): int
    {
        $directory = getcwd();

        \Leaf\FS\File::write("$directory/.env", function ($env) {
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

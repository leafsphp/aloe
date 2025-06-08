<?php

namespace Aloe\Command;

use Aloe\Command;

class EnvSetCommand extends Command
{
    protected static $defaultName = 'env:set';
    public $description = 'Set a new environment variable for your app';
    public $help = 'Set a new environment variable in the .env file and update .env.example if it exists.';

    protected function configure()
    {
        $this
            ->addArgument('key', null, 'The environment variable key')
            ->addArgument('value', null, 'The environment variable value');
    }

    protected function handle()
    {
        if (!file_exists(Config::rootpath('.env'))) {
            $process = $this->runProcess(['php', 'leaf', 'env:generate']);

            if ($process !== 0) {
                $this->error('Couldn\'t generate .env file. Please run `leaf env:generate` first.');
                return 1;
            }
        }

        $directory = getcwd();

        \Leaf\FS\File::write("$directory/.env", function ($env) {
            $key = $this->argument('key');
            $value = $this->argument('value');

            if (strpos($env, $key) !== false) {
                $this->info("$key already exists, updating value...");
                $env = preg_replace("/^$key=(.*)/m", "$key=$value", $env);
            } else {
                $this->info("Setting new environment variable: $key");
                $env .= "\n$key=$value\n";
            }

            return $env;
        });

        if (file_exists(Config::rootpath('.env.example'))) {
            \Leaf\FS\File::write(Config::rootpath('.env.example'), function ($envExample) {
                $key = $this->argument('key');

                if (strpos($envExample, $key) === false) {
                    $envExample .= "\n$key=\n";
                }

                return $envExample;
            });
        }

        $this->info("Environment updated successfully.");

        return 0;
    }
}

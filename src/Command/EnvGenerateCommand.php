<?php

namespace Aloe\Command;

use Aloe\Command;

class EnvGenerateCommand extends Command
{
    protected static $defaultName = "env:generate";
    public $description = "Generate .env file";
    public $help = "Generate .env file";

    protected function handle()
    {
        if (file_exists(Config::rootpath('.env'))) {
            return $this->error(".env already exists");
        }

        if (copy(__DIR__ . "/stubs/.env.stub", Config::rootpath('.env'))) {
            return $this->comment(".env generated successfully!");
        }

        $this->comment("Couldn't generate env file");
    }
}

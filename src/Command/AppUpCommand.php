<?php

namespace Aloe\Command;

class AppUpCommand extends \Aloe\Command
{
    protected static $defaultName = "app:up";
    public $description = "Remove app from maintainance mode";
    public $help = "Set app in normal mode";

    protected function handle()
    {
        $env = Config::rootpath(".env");
        $envContent = file_get_contents($env);
        $envContent = str_replace(
            'APP_DOWN=true',
            'APP_DOWN=false',
            $envContent
        );
        file_put_contents($env, $envContent);

        $index = Config::rootpath("index.php");
        $indexContent = file_get_contents($index);
        $indexContent = str_replace(
            ['(["mode" => "down"])', '["mode" => "down"]'],
            '',
            $indexContent
        );
        file_put_contents($index, $indexContent);

        $this->comment("App is now out of down mode...");
    }
}

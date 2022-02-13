<?php

namespace Aloe\Command;

class AppDownCommand extends \Aloe\Command
{
    protected static $defaultName = 'app:down';
    public $description = 'Place app in maintainance mode';
    public $help = 'Set app in maintainance mode';

    protected function handle()
    {
        $env = Config::rootpath('.env');
        $envContent = file_get_contents($env);
        $envContent = str_replace(
            'APP_DOWN=false',
            'APP_DOWN=true',
            $envContent
        );
        file_put_contents($env, $envContent);

        $file = Config::rootpath('index.php');
        $fileContent = file_get_contents($file);
        $fileContent = str_replace(
            ['$app = new Leaf\App;', '$app = new Leaf\App();'],
            '$app = new Leaf\App([\'mode\' => \'down\']);',
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $this->comment('App now running in down mode...');
    }
}

<?php

namespace Aloe\Command;

class AppDownCommand extends \Aloe\Command
{
    protected static $defaultName = 'app:down';
    public $description = 'Place app in maintainance mode';
    public $help = 'Set app in maintainance mode';

    protected function handle()
    {
        $file = Config::rootpath('.env');
        $fileContent = file_get_contents($file);
        $fileContent = str_replace(
            ['APP_DOWN=false', 'APP_DOWN = false'],
            'APP_DOWN=true',
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $this->comment('App now running in down mode...');
        $this->info('You might need to restart your server to see changes');

        return 0;
    }
}

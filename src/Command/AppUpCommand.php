<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class AppUpCommand extends Command
{
    protected $signature = 'app:up';
    protected $description = 'Remove app from maintenance mode';
    protected $help = 'Set app in normal mode';

    protected function handle()
    {
        $env = getcwd() . '/.env';

        $envContent = file_get_contents($env);
        $envContent = str_replace(
            ['APP_DOWN=true', 'APP_DOWN = true'],
            'APP_DOWN=false',
            $envContent
        );

        file_put_contents($env, $envContent);

        $this->comment('App is now out of down mode...');
        $this->info('You might need to restart your server to see changes');

        return 0;
    }
}

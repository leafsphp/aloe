<?php

namespace Aloe\Command;

class LinkCommand extends \Aloe\Command
{
    protected static $defaultName = 'link';
    public $description = 'Create a symbolic link for the storage directory';
    public $help = 'Create a symbolic link for the storage directory';

    protected function handle()
    {
        $this->info('Creating symbolic link for storage directory...');

        $publicPath = Config::rootpath('/public');
        $storagePath = Config::rootpath(StoragePath('app/public'));

        if (file_exists("$publicPath/storage")) {
            $this->error('Symbolic link already exists');

            return 1;
        }

        if (!file_exists($storagePath)) {
            storage()->createFolder($storagePath, [
                'recursive' => true,
            ]);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // convert forward slashes to backslashes
            $publicPath = str_replace('/', '\\', $publicPath);
            $storagePath = str_replace('/', '\\', $storagePath);

            $this->writeln(asComment('Experimental: ') . 'This command is experimental and may not work on Windows');
            $this->writeln(shell_exec("mklink /J $publicPath\\storage $storagePath"));

        } else {
            $this->writeln(shell_exec("ln -s $storagePath $publicPath/storage"));
        }

        $this->info(PHP_EOL . 'Symbolic link created successfully');
    }
}

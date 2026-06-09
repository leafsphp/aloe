<?php

namespace Aloe\Command;

class StorageLinkCommand extends \Aloe\Command
{
    protected static $defaultName = 'storage:link';

    public $description = 'Create a symbolic link for the storage directory';
    public $help = 'Create a symbolic link for the storage directory';

    protected function config()
    {
    }

    protected function handle()
    {
        $this->writeln('');
        $this->info('Creating symbolic link for storage directory...');

        $publicPath = getcwd() . '/public';
        $storagePath = StoragePath('app/public');

        if (!file_exists($storagePath)) {
            $this->error('Storage directory does not exist');
            return;
        }

        if (!file_exists($publicPath)) {
            $this->error('Public directory does not exist');
            return;
        }

        if (file_exists("$publicPath/storage")) {
            $this->error('Symbolic link already exists');
            return;
        }

        // Check if shell_exec exists and is not disabled
        if (
            !function_exists('shell_exec') ||
            in_array('shell_exec', array_map('trim', explode(',', ini_get('disable_functions'))))
        ) {
            $this->error('shell_exec() is disabled or unavailable on this server');
            return;
        }

        $this->writeln('');

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

            // convert forward slashes to backslashes
            $publicPath = str_replace('/', '\\', $publicPath);
            $storagePath = str_replace('/', '\\', $storagePath);

            $this->writeln(
                asComment("Experimental: ") .
                "This command is experimental and may not work on Windows"
            );

            $output = shell_exec(
                'mklink /J "' . $publicPath . '\\storage" "' . $storagePath . '"'
            );

        } else {

            $output = shell_exec(
                'ln -s "' . $storagePath . '" "' . $publicPath . '/storage"'
            );
        }

        $this->writeln($output);

        $this->info(PHP_EOL . 'Symbolic link created successfully');
    }
}

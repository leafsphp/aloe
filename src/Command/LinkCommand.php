<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class LinkCommand extends Command
{
    protected $signature = 'link';
    protected $description = 'Create a symbolic link for the storage directory';
    protected $help = 'Create a symbolic link for the storage directory';

    protected function handle()
    {
        $this->info('==> Creating symbolic link for storage directory...');

        $publicPath = getcwd() . '/public';
        $storagePath = getcwd() . StoragePath('app/public');

        if (file_exists("$publicPath/storage")) {
            $this->error('Symbolic link already exists');
            return 1;
        }

        if (!file_exists(filename: $storagePath)) {
            \Leaf\FS\Directory::create($storagePath, [
                'recursive' => true,
            ]);
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // convert forward slashes to backslashes
            $publicPath = str_replace('/', '\\', $publicPath);
            $storagePath = str_replace('/', '\\', $storagePath);

            $this->writeln('<comment>Experimental: </comment>This command is experimental and may not work on Windows');
            $this->writeln(shell_exec("mklink /J $publicPath\\storage $storagePath"));

        } else {
            try {
                shell_exec("ln -s $storagePath $publicPath/storage");
            } catch (\Throwable $th) {
                $this->error('Failed to create symbolic link: ' . $th->getMessage());
                return 1;
            }
        }

        $this->writeln('<info>✔</info> Symbolic link created successfully');
    }
}

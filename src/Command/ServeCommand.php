<?php

namespace Aloe\Command;

use Aloe\Command;

class ServeCommand extends Command
{
    protected static $defaultName = 'serve';
    public $description = 'Start the leaf development server';
    public $help = 'Run your Leaf app on PHP\'s local development server';

    protected function config()
    {
        $this->setOption('port', 'p', 'optional', 'Port to run Leaf app on', _env('SERVER_PORT', 5500));
        $this->setOption('path', 't', 'optional', 'Path to your app', getcwd() . '/public');
        $this->setOption('host', 's', 'optional', 'Your application host', 'localhost');
        $this->setOption('no-concurrent', 'nc', 'optional', 'Run PHP server without Vite server', false);
    }

    protected function handle()
    {
        $useConcurrent = true;

        $port = $this->option('port');
        $path = $this->option('path');
        $host = $this->option('host');
        $noConcurrent = $this->option('no-concurrent');

        if ($noConcurrent || !class_exists('Leaf\Vite') || !file_exists(getcwd() . '/vite.config.js')) {
            $useConcurrent = false;
        }

        if (!is_dir($path)) {
            $this->error("Directory $path does not exist");

            return 1;
        }

        while (true) {
            $defSocket = @fsockopen($host, $port, $errno, $errstr, 1);
            $localSocket = @fsockopen('localhost', $port, $errno, $errstr, 1);

            if ($defSocket) {
                $this->writeln("Port $port is already in use by $host, trying port " . ($port + 1) . '...');
                $port++;
            } elseif (!$localSocket) {
                break;
            } else {
                $this->error('WARNING:');
                $this->writeln(asComment("While port $port is available on $host, it is already in use by localhost"));

                break;
            }
        }

        if ($useConcurrent) {
            $this->writeln("\nVite detected, running Leaf server and Vite server concurrently\n");
            $this->info("Happy gardening!!\n");

            if (!file_exists(getcwd() . '/node_modules')) {
                $this->writeln(shell_exec('npm i'));
            }

            \Aloe\Core::run(
                "npx concurrently -c \"#3eaf7c,#bd34fe\" \"php -S $host:$port -t $path\" \"npm run dev\" --names=server,vite --colors",
                $this->output()
            );
        } else {
            $this->writeln(shell_exec("php -S $host:$port -t $path"));
        }

        return 0;
    }
}

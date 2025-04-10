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
        $this->setOption('no-concurrent', 'c', 'none', 'Run PHP server without Vite server');
    }

    protected function handle()
    {
        $useConcurrent = true;
        $redisDetected = class_exists('Leaf\Redis');
        $jobsDetected = class_exists('Leaf\Job') && file_exists(getcwd() . '/app/jobs');
        $viteDetected = class_exists('Leaf\Vite') || file_exists(getcwd() . '/vite.config.js');

        $port = $this->option('port');
        $path = $this->option('path');
        $host = $this->option('host');
        $noConcurrent = $this->option('no-concurrent');

        if ($noConcurrent || (!$redisDetected && !$jobsDetected && !$viteDetected)) {
            $useConcurrent = false;
        }

        if (!is_dir($path)) {
            $this->error("Directory $path does not exist");
            return 1;
        }

        $this->writeln(asComment(" _                __   __  ____     ______
| |    ___  __ _ / _| |  \/  \ \   / / ___|
| |   / _ \/ _` | |_  | |\/| |\ \ / / |
| |__|  __/ (_| |  _| | |  | | \ V /| |___
|_____\___|\__,_|_|   |_|  |_|  \_/  \____|\n"));

        while (true) {
            $defSocket = @fsockopen($host, $port, $errno, $errstr, 1);
            $localSocket = @fsockopen('localhost', $port, $errno, $errstr, 1);

            if ($defSocket) {
                $this->writeln(asInfo(" > ") . "Port $port is already in use by $host, trying port " . ($port + 1) . '...');
                $port++;
            } elseif (!$localSocket) {
                break;
            } else {
                $this->error('WARNING:');
                $this->writeln(asComment("While port $port is available on $host, it is already in use by localhost"));

                break;
            }
        }

        if (\Leaf\FS\File::exists(getcwd() . '/.env')) {
            \Leaf\FS\File::write(getcwd() . '/.env', function ($content) use ($port) {
                return preg_replace('/APP_URL=(.*)/', 'APP_URL=http://' . $this->option('host') . ':' . $port, $content);
            });
        }

        if ($useConcurrent) {
            $commands = [
                '#3eaf7c' => ['Leaf', "\"php -S $host:$port -t $path\""],
            ];

            if (!file_exists(getcwd() . '/node_modules') && file_exists(getcwd() . '/package.json')) {
                $this->writeln(shell_exec('npm install'));
            }

            if ($viteDetected) {
                $this->writeln(asInfo(' > ') . 'Vite detected, starting Vite server concurrently');
                $commands['#bd34fe'] = ['Vite', '"npm run dev"'];
            }

            if ($redisDetected) {
                $this->writeln(asInfo(' > ') . 'Redis detected, starting Redis server concurrently');
                \Leaf\FS\Directory::create(getcwd() . '/storage/database');
                $commands['#ff4438'] = ['Redis', '"redis-server --dir storage/database"'];
            }

            if ($jobsDetected) {
                $this->writeln(asInfo(' > ') . 'Jobs detected, starting Queue workers concurrently');
                $commands['#f9c851'] = ['Workers', '"php leaf queue:work"'];
            }

            $this->info("\nHappy gardening 🍁\n");

            $colors = implode(',', array_keys($commands));
            $commandNames = array_map(function ($cmd) {
                return $cmd[0];
            }, $commands);
            $commandsToRun = array_map(function ($cmd) {
                return $cmd[1];
            }, $commands);

            \Aloe\Core::run(
                "npx concurrently -c \"$colors\" " . implode(' ', $commandsToRun) . " --names=" . implode(',', $commandNames) . " --colors",
                $this->output()
            );
        } else {
            $this->info("\nHappy gardening 🍁\n");
            $this->writeln(shell_exec("php -S $host:$port -t $path"));
        }

        return 0;
    }
}

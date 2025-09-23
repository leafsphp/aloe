<?php

namespace Aloe\Command;

use Aloe\Command;

class ServeCommand extends Command
{
    protected static $defaultName = 'serve';
    public $description = 'Start the leaf development server';
    public $help = 'Run your Leaf app on PHP\'s local development server';

    protected $host;
    protected $port;
    protected $path;

    protected function config()
    {
        $this
            ->setOption('port', 'p', 'optional', 'Port to run Leaf app on', _env('APP_PORT', 5500))
            ->setOption('path', 't', 'optional', 'Path to your app', getcwd() . '/public')
            ->setOption('host', 's', 'optional', 'Your application host', 'localhost')
            ->setOption('no-concurrent', 'c', 'none', 'Run PHP server without Vite server')
            ->setOption('no-env-watch', 'w', 'none', 'Run PHP server without automatic .env file watching');
    }

    protected function handle()
    {
        $useConcurrent = true;
        $redisDetected = class_exists('Leaf\Redis');
        $jobsDetected = class_exists('Leaf\Job') && file_exists(getcwd() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'jobs');
        $viteDetected = class_exists('Leaf\Vite') || file_exists(getcwd() . DIRECTORY_SEPARATOR . 'vite.config.js');

        $this->port = $this->option('port');
        $this->path = $this->option('path');
        $this->host = $this->option('host');

        $noConcurrent = $this->option('no-concurrent');

        if ($noConcurrent || (!$redisDetected && !$jobsDetected && !$viteDetected)) {
            $useConcurrent = false;
        }

        if (!is_dir($this->path)) {
            $this->error("Directory {$this->path} does not exist");
            return 1;
        }

        $this->writeln(asComment(" _                __   __  ____     ______
| |    ___  __ _ / _| |  \/  \ \   / / ___|
| |   / _ \/ _` | |_  | |\/| |\ \ / / |
| |__|  __/ (_| |  _| | |  | | \ V /| |___
|_____\___|\__,_|_|   |_|  |_|  \_/  \____|\n"));

        $maxPortsToCheck = 50;
        $portsChecked = 0;

        while ($portsChecked < $maxPortsToCheck) {
            $portsChecked++;

            $socket = @fsockopen($this->host, $this->port, $errno, $errstr, 0.1);

            if ($socket) {
                fclose($socket);
                $this->writeln(asInfo(" > ") . "Port {$this->port} is already in use, trying port " . ($this->port + 1) . '...');
                $this->port++;
            } else {
                break;
            }
        }

        if ($portsChecked >= $maxPortsToCheck) {
            $this->error("Could not find an available port after $maxPortsToCheck attempts");
            return 1;
        }

        if (\Leaf\FS\File::exists(getcwd() . '/.env')) {
            \Leaf\FS\File::write(getcwd() . '/.env', function ($content) {
                $content = preg_replace('/APP_URL=(.*)/', "APP_URL=http://{$this->host}:{$this->port}", $content);
                $content = preg_replace('/APP_PORT=(.*)/', "APP_PORT={$this->port}", $content);

                return $content;
            });
        }

        if ($useConcurrent && !$this->hasInternetConnection()) {
            $this->writeln(asInfo(' > ') . 'No internet connection detected. Falling back to simple server mode.');

            if ($viteDetected) {
                $this->writeln(asInfo(' > ') . 'Vite detected → remember to start the Vite server separately with "npm run dev"');
            }

            if ($redisDetected) {
                $this->writeln(asInfo(' > ') . 'Redis detected → remember to start your Redis server separately');
            }

            if ($jobsDetected) {
                $this->writeln(asInfo(' > ') . 'Jobs detected → remember to start your queue workers separately with "php leaf queue:work"');
            }

            $useConcurrent = false;
        }

        if ($useConcurrent) {
            $commands = [
                '#3eaf7c' => [
                    'Leaf',
                    $this->option('no-env-watch') || !file_exists(getcwd() . DIRECTORY_SEPARATOR . '.env')
                    ? $this->buildPhpServerCommand()
                    : $this->buildWatcherCommand()
                ],
            ];

            if ($viteDetected) {
                $this->writeln(asInfo(' > ') . 'Vite detected → starting Vite server concurrently');
                $commands['#bd34fe'] = ['Vite', $this->buildNpmRunCommand('dev')];
            }

            if ($redisDetected) {
                $redisHost = _env('REDIS_HOST', '127.0.0.1');
                $redisPort = _env('REDIS_PORT', 6379);

                if (strpos($redisHost, 'tls://') !== false || strpos($redisHost, 'rediss://') !== false) {
                    $this->writeln(asInfo(' > ') . 'Managed Redis detected (TLS) → skipping embedded server startup');
                } else {
                    $redisPingCommand = $this->isWindows() ?
                        "redis-cli -h $redisHost -p $redisPort ping 2>nul" :
                        "redis-cli -h $redisHost -p $redisPort ping 2>/dev/null";

                    exec($redisPingCommand, $output, $status);

                    if ($status === 0 && isset($output[0]) && $output[0] === 'PONG') {
                        $this->writeln(asInfo(' > ') . "Redis detected at $redisHost:$redisPort → already running, skipping embedded server startup");
                    } else {
                        $this->writeln(asInfo(' > ') . "Redis detected (local) → starting embedded Redis server");

                        \Leaf\FS\Directory::create(getcwd() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'database');
                        $commands['#ff4438'] = ['Redis', '"redis-server --dir storage' . DIRECTORY_SEPARATOR . 'database"'];
                    }
                }
            }

            if ($jobsDetected) {
                $this->writeln(asInfo(' > ') . 'Jobs detected → starting queue workers concurrently');
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

            if ($this->option('no-env-watch') || !file_exists(getcwd() . DIRECTORY_SEPARATOR . '.env') || !$this->hasInternetConnection()) {
                $this->writeln(shell_exec($this->buildPhpServerCommand()) ?? "");
            } else {
                $this->writeln(shell_exec($this->buildWatcherCommand()) ?? "");
            }
        }

        return 0;
    }

    /**
     * Check if there's an internet connection
     */
    protected function hasInternetConnection()
    {
        $output = shell_exec(
            $this->isWindows()
            ? 'ping -n 1 registry.npmjs.org >nul 2>&1'
            : 'ping -c 1 registry.npmjs.org >/dev/null 2>&1'
        ) ?? '';

        return strpos($output, 'TTL') !== false || strpos($output, 'bytes from') !== false;
    }

    /**
     * Check if running on Windows
     */
    protected function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Build PHP server command with proper escaping for the platform
     */
    protected function buildPhpServerCommand()
    {
        if ($this->isWindows()) {
            return "php -S {$this->host}:{$this->port} -t " . escapeshellarg($this->path);
        } else {
            return "php -S {$this->host}:{$this->port} -t \"{$this->path}\"";
        }
    }

    /**
     * Build watcher command with proper escaping for the platform
     */
    protected function buildWatcherCommand()
    {
        $phpCommand = $this->buildPhpServerCommand();

        if ($this->isWindows()) {
            return "npx @leafphp/watcher --watch .env --exec " . escapeshellarg($phpCommand);
        } else {
            return "\"npx @leafphp/watcher --watch .env --exec \\\"$phpCommand\\\"\"";
        }
    }

    /**
     * Build npm run command with proper escaping for the platform
     */
    protected function buildNpmRunCommand($script)
    {
        if ($this->isWindows()) {
            return "npm run $script";
        } else {
            return "\"npm run $script\"";
        }
    }
}

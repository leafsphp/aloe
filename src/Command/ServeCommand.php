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
        $this->setOption('path', 't', 'optional', 'Path to your app', getcwd().'/public');
		$this->setOption('host', 's', 'optional', 'Your application host', 'localhost');
    }

    protected function handle()
    {
        $port = $this->option('port');
        $path = $this->option('path');
        $host = $this->option('host');

        # check if directory exists
        if (!is_dir($path)) {
            $this->error("Directory $path does not exist");
            return;
        }

        # check if port is in use by $host and localhost
        $this->writeln('');
        while (true) {
            $defSocket = @fsockopen($host, $port, $errno, $errstr, 1);
            $localSocket = @fsockopen('localhost', $port, $errno, $errstr, 1);

            if($defSocket){
                $this->error("Port $port is already in use by $host, trying port " . ($port + 1));
                $port++;
            } else{
                
                if(!$localSocket) break;

                $this->error("WARNING:");
                $this->writeln(asComment("While port $port is available on $host, it is already in use by localhost"));
                break;
            } 
        }

        $this->writeln(PHP_EOL. "Server started on " . asComment("http://$host:$port"));
        $this->info("Happy gardening!!" . PHP_EOL);

        $this->writeln(shell_exec("php -S $host:$port -t $path"));

        return;
    }
}

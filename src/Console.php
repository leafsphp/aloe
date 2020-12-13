<?php
namespace Aloe;

require __DIR__ . "/helpers.php";

use Symfony\Component\Console\Application;

class Console
{
    private $app;

    public function __construct($app = "Aloe CLI", $version = "v1.0")
    {
        $this->app = new Application(asComment($app), $version);    
        $this->load();
    }

    /**
     * Load default console commands
     */
    public function load()
    {
        $commands = [
            // Random Commands
            \Aloe\Command\ServerCommand::class,
            \Aloe\Command\ConsoleCommand::class,
            \Aloe\Command\AppDownCommand::class,
            \Aloe\Command\AppUpCommand::class,
            // Generate Commands
            \Aloe\Command\GenerateMigrationCommand::class,
            \Aloe\Command\GenerateModelCommand::class,
            \Aloe\Command\GenerateHelperCommand::class,
            \Aloe\Command\GenerateControllerCommand::class,
            \Aloe\Command\GenerateSeedCommand::class,
            \Aloe\Command\GenerateConsoleCommand::class,
            \Aloe\Command\GenerateFactoryCommand::class,
            // Delete Commands
            \Aloe\Command\DeleteModelCommand::class,
            \Aloe\Command\DeleteSeedCommand::class,
            \Aloe\Command\DeleteFactoryCommand::class,
            \Aloe\Command\DeleteControllerCommand::class,
            \Aloe\Command\DeleteConsoleCommand::class,
            // Database Commands
            \Aloe\Command\DatabaseInstallCommand::class,
            \Aloe\Command\DatabaseMigrationCommand::class,
            \Aloe\Command\DatabaseRollbackCommand::class,
            \Aloe\Command\DatabaseSeedCommand::class
        ];

        $this->register($commands);
    }

    /**
     * Register a custom command
     * 
     * @param array|Symfony\Component\Console\Command\Command $command: Command to run
     * 
     * @return void
     */
    public function register($command)
    {
        if (is_array($command)) {
            foreach ($command as $item) {
                $this->register($item);
            }
        } else {
            $this->app->add(new $command);
        }
    }

    /**
     * Run the console app
     */
    public function run()
    {
        $this->app->run();
    }
}

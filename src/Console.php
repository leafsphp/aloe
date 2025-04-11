<?php

namespace Aloe;

require __DIR__ . '/helpers.php';

use Symfony\Component\Console\Application;

/**
 * Aloe CLI
 * -----
 * Smart and interactive console/generator
 * for your leaf MVC applications
 */
class Console
{
    /**
     * Instance of symfony console app
     */
    private static $app;

    public function __construct($version = 'v1.0')
    {
        static::$app = new Application(asComment('Leaf MVC'), $version);

        static::register([
            // Random Commands
            \Aloe\Command\AppDownCommand::class,
            \Aloe\Command\AppUpCommand::class,
            \Aloe\Command\InteractCommand::class,
            \Aloe\Command\ServeCommand::class,

            // Aloe Commands
            \Aloe\Command\DevToolsCommand::class,
            \Aloe\Command\KeyGenerateCommand::class,

            // config commands
            \Aloe\Command\ConfigLibCommand::class,
            \Aloe\Command\ConfigPublishCommand::class,

            // Env Commands
            \Aloe\Command\EnvGenerateCommand::class,

            // Database Commands
            \Aloe\Command\DatabaseMigrationCommand::class,
            \Aloe\Command\DatabaseResetCommand::class,
            \Aloe\Command\DatabaseRollbackCommand::class,
            \Aloe\Command\DatabaseSeedCommand::class,

            // Delete Commands
            \Aloe\Command\DeleteModelCommand::class,
            \Aloe\Command\DeleteControllerCommand::class,
            \Aloe\Command\DeleteConsoleCommand::class,
            \Aloe\Command\DeleteSchemaCommand::class,

            // Generate Commands
            \Aloe\Command\GenerateConsoleCommand::class,
            \Aloe\Command\GenerateControllerCommand::class,
            \Aloe\Command\GenerateHelperCommand::class,
            \Aloe\Command\GenerateMailerCommand::class,
            \Aloe\Command\GenerateMiddlewareCommand::class,
            \Aloe\Command\GenerateModelCommand::class,
            \Aloe\Command\GenerateSchemaCommand::class,
            \Aloe\Command\GenerateTemplateCommand::class,

            // View commands
            \Aloe\Command\ViewBuildCommand::class,
            \Aloe\Command\ViewDevCommand::class,
            \Aloe\Command\ViewInstallCommand::class,

            // Symbolic link command
            \Aloe\Command\LinkCommand::class,

            // Scaffold Commands
            \Aloe\Command\ScaffoldAuthCommand::class,
            \Aloe\Command\ScaffoldMailCommand::class,
            \Aloe\Command\ScaffoldLandingPageCommand::class,
            \Aloe\Command\ScaffoldWaitlistCommand::class,
            \Aloe\Command\ScaffoldShadcnCommand::class,
        ]);
    }

    /**
     * Register a custom command
     *
     * @param array|\Symfony\Component\Console\Command\Command $command: Command(s) to run
     *
     * @return void
     */
    public static function register($command)
    {
        if (is_array($command)) {
            foreach ($command as $item) {
                static::register($item);
            }
        } else {
            static::$app->add(new $command());
        }
    }

    /**
     * Run the console app
     */
    public static function run()
    {
        static::$app->run();
    }
}

<?php

namespace Aloe;

require __DIR__ . '/helpers.php';

use Symfony\Component\Console\Application;

/**
 * Aloe CLI
 * -----
 * Smart and interactive console/generator
 * for your leaf MVC applications
 *
 * @author Michael Darko <mychi.darko@gmail.com>
 * @copyright 2019-2022 Michael Darko
 * @link https://leafphp.dev/aloe-cli/
 * @license MIT
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
            \Aloe\Command\ServeCommand::class,
            \Aloe\Command\InteractCommand::class,
            \Aloe\Command\AppDownCommand::class,
            \Aloe\Command\AppUpCommand::class,

            // Aloe Commands
            \Aloe\Command\DevToolsCommand::class,
            \Aloe\Command\KeyGenerateCommand::class,

            // auth Commands
            \Aloe\Command\AuthScaffoldCommand::class,

            // Env Commands
            \Aloe\Command\EnvGenerateCommand::class,

            // Generate Commands
            \Aloe\Command\GenerateMailerCommand::class,
            \Aloe\Command\GenerateMigrationCommand::class,
            \Aloe\Command\GenerateModelCommand::class,
            \Aloe\Command\GenerateHelperCommand::class,
            \Aloe\Command\GenerateControllerCommand::class,
            \Aloe\Command\GenerateSeedCommand::class,
            \Aloe\Command\GenerateConsoleCommand::class,
            \Aloe\Command\GenerateFactoryCommand::class,
            \Aloe\Command\GenerateTemplateCommand::class,

            // Delete Commands
            \Aloe\Command\DeleteModelCommand::class,
            \Aloe\Command\DeleteSeedCommand::class,
            \Aloe\Command\DeleteFactoryCommand::class,
            \Aloe\Command\DeleteControllerCommand::class,
            \Aloe\Command\DeleteConsoleCommand::class,
            \Aloe\Command\DeleteMigrationCommand::class,

            // Database Commands
            \Aloe\Command\DatabaseInstallCommand::class,
            \Aloe\Command\DatabaseMigrationCommand::class,
            \Aloe\Command\DatabaseResetCommand::class,
            \Aloe\Command\DatabaseRollbackCommand::class,
            \Aloe\Command\DatabaseSeedCommand::class,

            // Mail commands
            \Aloe\Command\MailSetupCommand::class,

            // View commands
            \Aloe\Command\ViewBuildCommand::class,
            \Aloe\Command\ViewDevCommand::class,
            \Aloe\Command\ViewInstallCommand::class,

            // Symbolic link command
            \Aloe\Command\LinkCommand::class,
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
            static::$app->add(new $command);
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

<?php

namespace Aloe;

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
        static::$app = sprout()->createApp([
            'name' => '<comment> _                __   __  ____     ______
| |    ___  __ _ / _| |  \/  \ \   / / ___|
| |   / _ \/ _` | |_  | |\/| |\ \ / / |
| |__|  __/ (_| |  _| | |  | | \ V /| |___
|_____\___|\__,_|_|   |_|  |_|  \_/  \____| by Leaf PHP</comment>',
            'version' => $version,
        ]);

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
            \Aloe\Command\EnvSetCommand::class,

            // Delete Commands
            \Aloe\Command\DeleteModelCommand::class,
            \Aloe\Command\DeleteControllerCommand::class,
            \Aloe\Command\DeleteConsoleCommand::class,

            // Generate Commands
            \Aloe\Command\GenerateConsoleCommand::class,
            \Aloe\Command\GenerateControllerCommand::class,
            \Aloe\Command\GenerateHelperCommand::class,
            \Aloe\Command\GenerateMailerCommand::class,
            \Aloe\Command\GenerateMiddlewareCommand::class,
            \Aloe\Command\GenerateModelCommand::class,
            \Aloe\Command\GenerateTemplateCommand::class,
            \Aloe\Command\GenerateRouteCommand::class,

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
     * @param array|\Leaf\Sprout\Command $command: Command(s) to run
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
            static::$app->register($command);
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

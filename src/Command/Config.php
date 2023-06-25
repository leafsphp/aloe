<?php

namespace Aloe\Command;

class Config
{
    /**The type of environment to run for aloe */
    public static $env = 'WEB';

    /**An array of all needed configurations */
    public static $configBlueprint = ['paths' => []];

    /**Aloe paths config file */
    public static $pathsConfig = 'config/paths.php';

    /**Seeder to run when db:seed is called */
    public static $seeder = \App\Database\Seeds\DatabaseSeeder::class;

    /**
     * Get or generate aloe config
     */
    public static function config()
    {
        $config = static::rootpath(static::$pathsConfig);

        if (file_exists($config)) {
            return require $config;
        }

        return static::$configBlueprint;
    }

    /**
     * Get or generate aloe paths
     */
    public static function paths($path = null)
    {
        $paths = static::config();
        $paths = !$path ? $paths : $paths[$path] ?? null;

        if (empty($paths) || !$paths) {
            $paths = require static::rootpath(static::$pathsConfig);
            $paths = !$path ? $paths : $paths[$path];
        }

        return $paths;
    }

    /**
     * Get project rootpath
     */
    public static function rootpath($file = null)
    {
        $path = dirname(__DIR__, 5) . "/$file";
        return str_replace('//', '/', $path);
    }
}

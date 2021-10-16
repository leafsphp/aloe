<?php

namespace Aloe\Command;

class Config
{
    /**The type of environment to run for aloe */
    public static $env = "WEB";

    /**An array of all needed configurations */
    public static $configBlueprint = ["paths" => []];

    /**Aloe config file path */
    public static $aloeConfig = "Config/aloe.php";

    /**Aloe paths config file */
    public static $pathsConfig = "Config/paths.php";

    /**Seeder to run when db:seed is called */
    public static $seeder = \App\Database\Seeds\DatabaseSeeder::class;

    /**
     * Get or generate aloe config
     */
    public static function config()
    {
        $config = static::rootpath(static::$aloeConfig);

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
        $paths = static::config()["paths"];
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
        $path = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . "/$file";
        return str_replace("//", "/", $path);
    }

    public static function controllersPath($file = null)
    {
        return static::rootpath(static::paths("controllersPath") . "/$file");
    }

    public static function viewsPath($file = null)
    {
        return static::rootpath(static::paths("viewsPath") . "/$file");
    }

    public static function configPath($file = null)
    {
        return static::rootpath(static::paths("configPath") . "/$file");
    }

    public static function modelsPath($file = null)
    {
        return static::rootpath(static::paths("modelsPath") . "/$file");
    }

    public static function migrationsPath($file = null)
    {
        return static::rootpath(static::paths("migrationsPath") . "/$file");
    }

    public static function seedsPath($file = null)
    {
        return static::rootpath(static::paths("seedsPath") . "/$file");
    }

    public static function commandsPath($file = null)
    {
        return static::rootpath(static::paths("commandsPath") . "/$file");
    }

    public static function helpersPath($file = null)
    {
        return static::rootpath(static::paths("helpersPath") . "/$file");
    }

    public static function factoriesPath($file = null)
    {
        return static::rootpath(static::paths("factoriesPath") . "/$file");
    }
}

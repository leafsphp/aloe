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
            return require static::rootpath(static::$pathsConfig);
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

    public static function controllers_path($file = null)
    {
        return static::rootpath(static::paths("controllers_path") . "/$file");
    }

    public static function views_path($file = null)
    {
        return static::rootpath(static::paths("views_path") . "/$file");
    }

    public static function config_path($file = null)
    {
        return static::rootpath(static::paths("config_path") . "/$file");
    }

    public static function models_path($file = null)
    {
        return static::rootpath(static::paths("models_path") . "/$file");
    }

    public static function migrations_path($file = null)
    {
        return static::rootpath(static::paths("migrations_path") . "/$file");
    }

    public static function seeds_path($file = null)
    {
        return static::rootpath(static::paths("seeds_path") . "/$file");
    }

    public static function commands_path($file = null)
    {
        return static::rootpath(static::paths("commands_path") . "/$file");
    }

    public static function helpers_path($file = null)
    {
        return static::rootpath(static::paths("helpers_path") . "/$file");
    }

    public static function factories_path($file = null)
    {
        return static::rootpath(static::paths("factories_path") . "/$file");
    }
}

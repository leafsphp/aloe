<?php
namespace Aloe\Command;

class Config
{
    public static $env = "WEB";

    public static $configBlueprint = ["paths" => []];
    
    public static function config()
    {
        $config = static::rootpath("Config/aloe.php");

        if (file_exists($config)) {
            return require $config;
        }

        return static::$configBlueprint;
    }

    public static function paths($path = null)
    {
        $paths = static::config()["paths"];
        $paths = !$path ? $paths : $paths[$path] ?? null;

        if (empty($paths) || !$paths) {
            return require static::rootpath("Config/paths.php");
        }

        return $paths;
    }

    public static function rootpath($file = null)
    {
        $path = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . "/$file";
        return str_replace("//", "/", $path);
    }

    public static function controllers_path($file = null)
    {
        return static::rootpath(static::paths("controllers_path") . "/$file");
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

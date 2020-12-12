<?php
namespace Aloe\Command;

class Config
{
    public static function rootpath($file = null)
    {
        return dirname(dirname(dirname(dirname(dirname(__DIR__))))) . "/$file";
    }

    public static function controllers_path($file = null)
    {
        return static::rootpath(controllers_path($file));
    }

    public static function models_path($file = null)
    {
        return static::rootpath(models_path($file));
    }

    public static function migrations_path($file = null)
    {
        return static::rootpath(migrations_path($file));
    }

    public static function seeds_path($file = null)
    {
        return static::rootpath(seeds_path($file));
    }

    public static function commands_path($file = null)
    {
        return static::rootpath(commands_path($file));
    }

    public static function helpers_path($file = null)
    {
        return static::rootpath(helpers_path($file));
    }

    public static function factories_path($file = null)
    {
        return static::rootpath(factories_path($file));
    }
}

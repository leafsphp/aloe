<?php

namespace Aloe;

use Leaf\FS;
use Aloe\Command\Config;

/**
 * Aloe Installer
 * -----------------
 * Quickly install directories and files in
 * a leaf workspace
 * 
 * @since 1.1.0-beta
 */
class Installer
{
    /**
     * Auto-magically copy all files and folders from
     * specified folder into Leaf workspace
     * 
     * @param string $installablesDir The folder holding items to install
     */
    public static function magicCopy($installablesDir)
    {
        $installables = FS::listFolders($installablesDir);

        foreach ($installables as $installableDir) {
            $dir = FS::listDir($installableDir);
            $trueDir = str_replace($installablesDir, '', $installableDir);

            foreach ($dir as $installable) {
                FS::superCopy(
                    "$installableDir/$installable",
                    Config::rootpath("app/$trueDir/$installable")
                );
            }
        }
    }

    /**
     * Install routes from routes folder into leaf workspace
     */
    public static function installRoutes($routesDir, $routeHome = 'app/routes/index.php')
    {
        $routeHome = Config::rootpath('app/routes/index.php');
        $routeData = FS::readFile($routeHome);
        $routes = FS::listDir($routesDir);

        foreach ($routes as $route) {
            $data = str_replace(
                "require __DIR__ . '/$route';",
                "",
                $routeData
            );
            FS::writeFile($routeHome, $data);
            FS::append($routeHome, "require __DIR__ . '/$route';");
        }
    }
}

<?php

namespace Aloe;

use Aloe\Command\Config;
use Leaf\FS\Directory;

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
        if (!Directory::copy($installablesDir, getcwd(), ['recursive' => true])) {
            echo "Couldn't install $installablesDir\n";
            echo json_encode(Directory::errors(), JSON_PRETTY_PRINT);
        }
    }

    /**
     * Install routes from routes folder into leaf workspace
     */
    public static function installRoutes($routesDir, $routeFile = 'index.php')
    {
        // $routeHome = Config::rootpath(RoutesPath($routeFile));
        // $routeData = FS::readFile($routeHome);
        // $routes = FS::listDir($routesDir);

        // foreach ($routes as $route) {
        //     $data = str_replace(
        //         "require __DIR__ . '/$route';",
        //         "",
        //         $routeData
        //     );
        //     FS::writeFile($routeHome, $data);
        //     FS::append($routeHome, "require __DIR__ . '/$route';");
        // }
    }

    /**
     * Install package from composer
     *
     * @param string $packages The packages to install
     */
    public static function installPackages(string $packages)
    {
        $parsedPackages = '';

        foreach (explode(' ', $packages) as $package) {
            $package = str_replace(
                ['composer require ', '@'],
                ['', ':'],
                $package
            );

            if (strpos($package, '/') === false) {
                $package = "leafs/$package";
            }

            $parsedPackages .= "$package ";
        }

        return shell_exec("composer require $parsedPackages --ansi");
    }
}

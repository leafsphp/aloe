<?php

declare(strict_types=1);

namespace Leaf\Console;

use Leaf\Sprout\Command;

class InstallCommand extends Command
{
    protected $signature = 'install
        {packages?* : package(s) to install. Can also include a version constraint, e.g. foo/bar or foo/bar@1.0.0}
        {--d|dev? : Install package as a dev dependency}';
    protected $description = 'Add a new package to your leaf app';
    protected $help = 'Install a new package';

    protected function handle()
    {
        $packages = $this->argument('packages');

        if (count($packages)) {
            return $this->install($packages);
        }

        return $this->installDependencies();
    }

    protected function installDependencies()
    {
        $composerJsonPath = getcwd() . '/composer.json';

        if (!file_exists($composerJsonPath)) {
            $this->writeln('<error>No composer.json found in the current directory. Pass in a package to add if you meant to install something.</error>');
            return 1;
        }
        ;

        if (!sprout()->composer()->install()->isSuccessful()) {
            return 1;
        }

        $this->writeln('<comment>packages installed successfully!</comment>');

        return 0;
    }

    /**
     * Install packages
     */
    protected function install($packages)
    {
        foreach ($packages as $package) {
            if (strpos($package, '/') == false) {
                $package = "leafs/$package";
            }

            $package = str_replace('@', ':', $package);

            $this->writeln("<info>Installing $package...</info>");

            if (
                !sprout()
                    ->process("composer require $package" . ($this->option('dev') ? ' --dev' : ''))
                    ->setTimeout(null)
                    ->run(function ($type, $line): void {
                        $this->writeln($line);
                    })
            ) {
                return 1;
            }

            $this->writeln("<comment>$package installed successfully!</comment>");
        }

        if (count($packages) > 1) {
            $this->writeln('<info>All packages installed</info>');
        }

        return 0;
    }
}

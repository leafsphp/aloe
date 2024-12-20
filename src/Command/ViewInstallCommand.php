<?php

declare(strict_types=1);

namespace Aloe\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ViewInstallCommand extends Command
{
    protected static $defaultName = 'view:install';

    protected function configure()
    {
        $this
            ->setHelp('Run a composer script')
            ->setDescription('Run a script in your composer.json')
            ->addOption('react', null, InputOption::VALUE_NONE, 'Install react')
            ->addOption('tailwind', null, InputOption::VALUE_NONE, 'Install tailwind')
            ->addOption('vue', null, InputOption::VALUE_NONE, 'Install vue');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('react')) {
            $this->installReact($output);
        }

        if ($input->getOption('vue')) {
            $this->installVue($output);
        }

        if ($input->getOption('tailwind')) {
            $this->installTailwind($output);
        }

        return 0;
    }

    /**
     * Install react
     */
    protected function installReact($output)
    {
        $output->writeln("📦  <info>Installing react...</info>\n");

        $directory = getcwd();
        $npm = \Aloe\Core::findNpm();
        $composer = \Aloe\Core::findComposer();
        $success = \Aloe\Core::run("$npm install @leafphp/vite-plugin @vitejs/plugin-react @inertiajs/react@^1.0 react@^18.0 react-dom@^18.0 vite", $output);

        if (!$success) {
            $output->writeln("❌  <error>Failed to install react</error>");
            return 1;
        }

        $output->writeln("\n✅  <info>React installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf React server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/inertia leafs/vite", $output);

        if (!$success) {
            $output->writeln("❌  <error>Failed to setup Leaf React server bridge</error>");
            return 1;
        }

        $isBladeProject = $this->isBladeProject();

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/react/' . ($isBladeProject ? 'blade' : 'bare-ui'),
            $directory,
            ['recursive' => true]
        );

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $output->writeln("\n⚛️   <info>React setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf view:dev <info>- start dev server</info>');
        $output->writeln("    php leaf view:build <info>- build for production</info>");

        return 0;
    }

    /**
     * Install tailwind
     */
    protected function installTailwind($output)
    {
        $directory = getcwd();
        $npm = \Aloe\Core::findNpm();
        $composer = \Aloe\Core::findComposer();

        $output->writeln("📦  <info>Installing tailwind...</info>\n");

        $success = \Aloe\Core::run("$npm install tailwindcss postcss autoprefixer @leafphp/vite-plugin vite", $output);

        if (!$success) {
            $output->writeln("❌  <error>Failed to install tailwind</error>");
            return 1;
        }

        $output->writeln("\n✅  <info>Tailwind CSS installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/vite", $output);

        if (!$success) {
            $output->writeln("❌  <error>Failed to setup Leaf server bridge</error>");
            return 1;
        }

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/tailwind/',
            $directory,
            ['recursive' => true]
        );

        $paths = require "$directory/config/paths.php";

        if (file_exists("$directory/app/views/js/app.js")) {
            $jsApp = file_get_contents("$directory/app/views/js/app.js");

            if (strpos($jsApp, "import '../css/app.css';") === false) {
                \Leaf\FS\File::write("$directory/app/views/js/app.js", function ($content) {
                    return "import '../css/app.css';\n$content";
                });
            }
        } else if (file_exists("$directory/app/views/js/app.jsx")) {
            $jsApp = file_get_contents("$directory/app/views/js/app.jsx");

            if (strpos($jsApp, "import '../css/app.css';") === false) {
                \Leaf\FS\File::write("$directory/app/views/js/app.jsx", function ($content) {
                    return "import '../css/app.css';\n$content";
                });
            }
        }

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $output->writeln("\n🎉  <info>Tailwind CSS setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf view:dev <info>- start dev server</info>');
        $output->writeln("    php leaf view:build <info>- build for production</info>\n");

        return 0;
    }

    /**
     * Install vue
     */
    protected function installVue($output)
    {
        $output->writeln("📦  <info>Installing Vue...</info>\n");

        $directory = getcwd();
        $npm = \Aloe\Core::findNpm();
        $composer = \Aloe\Core::findComposer();
        $success = \Aloe\Core::run("$npm install @leafphp/vite-plugin @vitejs/plugin-vue @inertiajs/vue3@^1.0 vue", $output);

        if (!$success) {
            $output->writeln("❌  <error>Failed to install Vue</error>");
            return 1;
        }

        $output->writeln("\n✅  <info>Vue installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf Vue server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/inertia leafs/vite", $output);

        if (!$success) {
            $output->writeln("❌  <error>Failed to setup Leaf Vue server bridge</error>");
            return 1;
        }

        $isBladeProject = $this->isBladeProject();

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/vue/' . ($isBladeProject ? 'blade' : 'bare-ui'),
            $directory,
            ['recursive' => true]
        );

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $output->writeln("\n⚛️   <info>Vue setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf view:dev <info>- start dev server</info>');
        $output->writeln("    php leaf view:build <info>- build for production</info>\n");

        return 0;
    }

    // ------------------------ utils ------------------------ //

    protected function isBladeProject($directory = null)
    {
        $isBladeProject = false;
        $directory = $directory ?? getcwd();

        if (file_exists("$directory/config/view.php")) {
            $viewConfig = require "$directory/config/view.php";
            $isBladeProject = strpos(strtolower($viewConfig['viewEngine'] ?? $viewConfig['view_engine'] ?? ''), 'blade') !== false;
        } else if (file_exists("$directory/composer.lock")) {
            $composerLock = json_decode(file_get_contents("$directory/composer.lock"), true);
            $packages = $composerLock['packages'] ?? [];

            foreach ($packages as $package) {
                if ($package['name'] === 'leafs/blade') {
                    $isBladeProject = true;
                    break;
                }
            }
        }

        return $isBladeProject;
    }
}

<?php

declare(strict_types=1);

namespace Aloe\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

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
            // ->addOption('pm', 'pm', InputOption::VALUE_OPTIONAL, 'Package manager to use', 'npm')
            ->addOption('svelte', null, InputOption::VALUE_NONE, 'Install svelte')
            ->addOption('vue', null, InputOption::VALUE_NONE, 'Install vue');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$input->getOption('react') && !$input->getOption('tailwind') && !$input->getOption('svelte') && !$input->getOption('vue')) {
            $helper = $this->getHelper('question');

            $options = $helper->ask(
                $input,
                $output,
                (new ChoiceQuestion(
                    '<info>? What do you want to install?</info>',
                    ['react', 'vue', 'svelte', 'tailwind']
                ))
                    ->setMultiselect(true)
                    ->setErrorMessage('❌ Invalid option selected!')
            );

            foreach ($options as $option) {
                $input->setOption($option, true);
            }
        }

        if ($input->getOption('react')) {
            $this->installReact($output);
        } elseif ($input->getOption('vue')) {
            $this->installVue($output);
        } elseif ($input->getOption('svelte')) {
            $this->installSvelte($output);
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
        $success = \Aloe\Core::run("$npm install @leafphp/vite-plugin @vitejs/plugin-react @inertiajs/react react react-dom vite tailwindcss @tailwindcss/vite", $output);
        
        if (!$success) {
            $output->writeln('❌  <error>Failed to install react</error>');
            return 1;
        }

        \Aloe\Core::run("$npm install -D tailwindcss-animate prettier prettier-plugin-organize-imports prettier-plugin-tailwindcss eslint eslint-config-prettier eslint-plugin-prettier eslint-plugin-react eslint-plugin-react-hooks", $output);

        $output->writeln("\n✅  <info>React installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf React server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/inertia leafs/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to setup Leaf React server bridge</error>');
            return 1;
        }

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/react/',
            $directory,
            ['recursive' => true]
        );

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        if (storage()->exists("$directory/vite.config.js")) {
            storage()->writeFile("$directory/vite.config.js", function ($content) {
                if (strpos($content, "@vitejs/plugin-react") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport react from '@vitejs/plugin-react';",
                        $content
                    );
                }

                if (strpos($content, "@tailwindcss/vite") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport tailwindcss from '@tailwindcss/vite';",
                        $content
                    );
                }

                if (strpos($content, "tailwindcss(") === false) {
                    $content = str_replace("leaf({", "tailwindcss(),\nleaf({", $content);
                }

                if (strpos($content, "react(") === false) {
                    $content = str_replace("leaf({", "react(),\nleaf({", $content);
                }

                return $content;
            });
        }

        if (storage()->exists("$directory/app/routes/_app.php")) {
            storage()->writeFile("$directory/app/routes/_app.php", function ($content) {
                if (strpos($content, 'inertia(') === false) {
                    return str_replace(
                        "app()->view('/', 'index');",
                        "app()->inertia('/', 'welcome', [
    'phpVersion' => PHP_VERSION
]);",
                        $content
                    );
                }

                return $content;
            });
        }

        if (file_exists("$directory/app/views/css/app.css")) {
            storage()->writeFile("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $output->writeln("\n⚛️   <info>React setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf serve <info>- start dev server</info>');
        $output->writeln('    php leaf view:build <info>- build for production</info>');

        return 0;
    }

    /**
     * Install svelte
     */
    protected function installSvelte($output)
    {
        $output->writeln("📦  <info>Installing svelte...</info>\n");

        $directory = getcwd();
        $npm = \Aloe\Core::findNpm();
        $composer = \Aloe\Core::findComposer();
        $success = \Aloe\Core::run("$npm add @leafphp/vite-plugin svelte @sveltejs/vite-plugin-svelte @inertiajs/svelte vite tailwindcss @tailwindcss/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to install svelte</error>');
            return 1;
        }

        \Aloe\Core::run("$npm install -D tailwindcss-animate prettier prettier-plugin-organize-imports prettier-plugin-tailwindcss eslint eslint-config-prettier eslint-plugin-svelte", $output);

        $output->writeln("\n✅  <info>Svelte installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf Svelte server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/inertia leafs/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to setup Leaf Svelte server bridge</error>');
            return 1;
        }

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/svelte/',
            $directory,
            ['recursive' => true]
        );

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        if (storage()->exists("$directory/vite.config.js")) {
            storage()->writeFile("$directory/vite.config.js", function ($content) {
                if (strpos($content, "@sveltejs/vite-plugin-svelte") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport { svelte } from '@sveltejs/vite-plugin-svelte'",
                        $content
                    );
                }

                if (strpos($content, "@tailwindcss/vite") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport tailwindcss from '@tailwindcss/vite';",
                        $content
                    );
                }

                if (strpos($content, "tailwindcss(") === false) {
                    $content = str_replace("leaf({", "tailwindcss(),\nleaf({", $content);
                }

                if (strpos($content, "svelte(") === false) {
                    $content = str_replace("leaf({", "svelte(),\nleaf({", $content);
                }

                return $content;
            });
        }

        if (storage()->exists("$directory/app/routes/_app.php")) {
            storage()->writeFile("$directory/app/routes/_app.php", function ($content) {
                if (strpos($content, 'inertia(') === false) {
                    return str_replace(
                        "app()->view('/', 'index');",
                        "app()->inertia('/', 'welcome', [
    'phpVersion' => PHP_VERSION
]);",
                        $content
                    );
                }

                return $content;
            });
        }

        if (file_exists("$directory/app/views/css/app.css")) {
            storage()->writeFile("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $output->writeln("\n⚛️   <info>Svelte setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf serve <info>- start dev server</info>');
        $output->writeln('    php leaf view:build <info>- build for production</info>');

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

        $success = \Aloe\Core::run("$npm install @leafphp/vite-plugin vite tailwindcss @tailwindcss/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to install tailwind</error>');
            return 1;
        }

        \Aloe\Core::run("$npm install -D tailwindcss-animate", $output);

        $output->writeln("\n✅  <info>Tailwind CSS installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to setup Leaf server bridge</error>');
            return 1;
        }

        if (\Leaf\FS\File::exists('vite.config.js')) {
            \Leaf\FS\File::write('vite.config.js', function ($content) {
                if (strpos($content, "@tailwindcss/vite") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport tailwindcss from '@tailwindcss/vite';",
                        $content
                    );
                }

                if (strpos($content, "tailwindcss(") === false) {
                    $content = str_replace("leaf({", "tailwindcss(),\nleaf({", $content);
                }

                return $content;
            });
        }

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/tailwind/',
            $directory,
            ['recursive' => true]
        );

        if (file_exists("$directory/app/views/js/app.js")) {
            $jsApp = file_get_contents("$directory/app/views/js/app.js");

            if (strpos($jsApp, "import '../css/app.css';") === false) {
                \Leaf\FS\File::write("$directory/app/views/js/app.js", function ($content) {
                    return "import '../css/app.css';\n$content";
                });
            }
        } elseif (file_exists("$directory/app/views/js/app.jsx")) {
            $jsApp = file_get_contents("$directory/app/views/js/app.jsx");

            if (strpos($jsApp, "import '../css/app.css';") === false) {
                \Leaf\FS\File::write("$directory/app/views/js/app.jsx", function ($content) {
                    return "import '../css/app.css';\n$content";
                });
            }
        }

        if (file_exists("$directory/app/views/css/app.css")) {
            storage()->writeFile("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $output->writeln("\n🎉  <info>Tailwind CSS setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf serve <info>- start dev server</info>');
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
        $success = \Aloe\Core::run("$npm install @leafphp/vite-plugin @vitejs/plugin-vue @inertiajs/vue3@^1.0 vue vite tailwindcss @tailwindcss/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to install Vue</error>');
            return 1;
        }

        \Aloe\Core::run("$npm install -D tailwindcss-animate prettier prettier-plugin-organize-imports prettier-plugin-tailwindcss eslint eslint-config-prettier eslint-plugin-vue", $output);

        $output->writeln("\n✅  <info>Vue installed successfully</info>");
        $output->writeln("🧱  <info>Setting up Leaf Vue server bridge...</info>\n");

        $success = \Aloe\Core::run("$composer require leafs/inertia leafs/vite", $output);

        if (!$success) {
            $output->writeln('❌  <error>Failed to setup Leaf Vue server bridge</error>');
            return 1;
        }

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/vue/',
            $directory,
            ['recursive' => true]
        );

        $package = json_decode(file_get_contents("$directory/package.json"), true);
        $package['type'] = 'module';
        $package['scripts']['dev'] = 'vite';
        $package['scripts']['build'] = 'vite build';
        file_put_contents("$directory/package.json", json_encode($package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        if (storage()->exists("$directory/vite.config.js")) {
            storage()->writeFile("$directory/vite.config.js", function ($content) {
                if (strpos($content, "@vitejs/plugin-vue") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport vue from '@vitejs/plugin-vue';",
                        $content
                    );
                }

                if (strpos($content, "@tailwindcss/vite") === false) {
                    $content = str_replace(
                        ["import leaf from '@leafphp/vite-plugin';", 'import leaf from "@leafphp/vite-plugin";'],
                        "import leaf from '@leafphp/vite-plugin';\nimport tailwindcss from '@tailwindcss/vite';",
                        $content
                    );
                }

                if (strpos($content, "tailwindcss(") === false) {
                    $content = str_replace("leaf({", "tailwindcss(),\nleaf({", $content);
                }

                if (strpos($content, "vue(") === false) {
                    $content = str_replace("leaf({", "vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),\nleaf({", $content);
                }

                return $content;
            });
        }

        if (storage()->exists("$directory/app/routes/_app.php")) {
            storage()->writeFile("$directory/app/routes/_app.php", function ($content) {
                if (strpos($content, 'inertia(') === false) {
                    return str_replace(
                        "app()->view('/', 'index');",
                        "app()->inertia('/', 'welcome', [
    'phpVersion' => PHP_VERSION
]);",
                        $content
                    );
                }

                return $content;
            });
        }

        if (file_exists("$directory/app/views/css/app.css")) {
            storage()->writeFile("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $output->writeln("\n⚛️   <info>Vue setup successfully</info>");
        $output->writeln("👉  Get started with the following commands:\n");
        $output->writeln('    php leaf serve <info>- start dev server</info>');
        $output->writeln("    php leaf view:build <info>- build for production</info>\n");

        return 0;
    }
}

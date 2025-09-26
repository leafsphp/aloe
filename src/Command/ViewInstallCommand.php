<?php

declare(strict_types=1);

namespace Aloe\Command;

use Leaf\Sprout\Command;

class ViewInstallCommand extends Command
{
    protected $signature = 'view:install
        {--react? : Install react}
        {--tailwind? : Install tailwind}
        {--svelte? : Install svelte}
        {--vue? : Install vue}';
    protected $description = 'Install frontend scaffolding';
    protected $help = 'Install frontend scaffolding';

    protected function handle()
    {
        $engine = $this->option('react')
            ? 'react'
            : ($this->option('svelte')
                ? 'svelte'
                : ($this->option('vue')
                    ? 'vue'
                    : ($this->option('tailwind')
                        ? 'tailwind'
                        : null)));

        if (!$engine) {
            $engine = sprout()->prompt([
                'type' => 'select',
                'message' => 'What do you want to install?',
                'options' => [
                    ['title' => 'React JS', 'value' => 'react'],
                    ['title' => 'Vue JS', 'value' => 'vue'],
                    ['title' => 'Svelte', 'value' => 'svelte'],
                    ['title' => 'Blade + Tailwind', 'value' => 'tailwind'],
                ],
            ]);
        }

        if ($engine === 'react') {
            $this->installReact();
        } elseif ($engine === 'vue') {
            $this->installVue();
        } elseif ($engine === 'svelte') {
            $this->installSvelte();
        }

        if ($engine === 'tailwind') {
            $this->installTailwind();
        }

        return 0;
    }

    /**
     * Install react
     */
    protected function installReact()
    {
        $this->writeln("📦  <info>Installing react...</info>\n");

        $directory = getcwd();

        if (!sprout()->npm()->install('npm install @leafphp/vite-plugin @vitejs/plugin-react @inertiajs/react react react-dom vite tailwindcss @tailwindcss/vite')) {
            $this->writeln('❌  <error>Failed to install react</error>');
            return 1;
        }

        sprout()
            ->process('npm install -D tailwindcss-animate prettier prettier-plugin-organize-imports prettier-plugin-tailwindcss eslint eslint-config-prettier eslint-plugin-prettier eslint-plugin-react eslint-plugin-react-hooks')
            ->run();

        $this->writeln("\n✅  <info>React installed successfully</info>");
        $this->writeln("🧱  <info>Setting up Leaf React server bridge...</info>\n");

        if (!sprout()->composer()->install('leafs/inertia leafs/vite')) {
            $this->writeln('❌  <error>Failed to setup Leaf React server bridge</error>');
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

        if (\Leaf\FS\File::exists("$directory/vite.config.js")) {
            \Leaf\FS\File::write("$directory/vite.config.js", function ($content) {
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

        if (\Leaf\FS\File::exists("$directory/app/routes/_app.php")) {
            \Leaf\FS\File::write("$directory/app/routes/_app.php", function ($content) {
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
            \Leaf\FS\File::write("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $this->writeln("\n⚛️   <info>React setup successfully</info>");
        $this->writeln("👉  Get started with the following commands:\n");
        $this->writeln('    php leaf serve <info>- start dev server</info>');
        $this->writeln('    php leaf view:build <info>- build for production</info>');

        return 0;
    }

    /**
     * Install svelte
     */
    protected function installSvelte()
    {
        $this->writeln("📦  <info>Installing svelte...</info>\n");

        $directory = getcwd();
        if (!sprout()->npm()->install('@leafphp/vite-plugin svelte @sveltejs/vite-plugin-svelte @inertiajs/svelte vite tailwindcss @tailwindcss/vite')) {
            $this->writeln('❌  <error>Failed to install svelte</error>');
            return 1;
        }

        sprout()->npm()->install('tailwindcss-animate prettier prettier-plugin-organize-imports prettier-plugin-tailwindcss eslint eslint-config-prettier eslint-plugin-svelte');

        $this->writeln("\n✅  <info>Svelte installed successfully</info>");
        $this->writeln("🧱  <info>Setting up Leaf Svelte server bridge...</info>\n");

        if (!sprout()->composer()->install('leafs/inertia leafs/vite')) {
            $this->writeln('❌  <error>Failed to setup Leaf Svelte server bridge</error>');
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

        if (\Leaf\FS\File::exists("$directory/vite.config.js")) {
            \Leaf\FS\File::write("$directory/vite.config.js", function ($content) {
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

        if (\Leaf\FS\File::exists("$directory/app/routes/_app.php")) {
            \Leaf\FS\File::write("$directory/app/routes/_app.php", function ($content) {
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
            \Leaf\FS\File::write("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $this->writeln("\n⚛️   <info>Svelte setup successfully</info>");
        $this->writeln("👉  Get started with the following commands:\n");
        $this->writeln('    php leaf serve <info>- start dev server</info>');
        $this->writeln('    php leaf view:build <info>- build for production</info>');

        return 0;
    }

    /**
     * Install tailwind
     */
    protected function installTailwind()
    {
        $directory = getcwd();

        $this->writeln("📦  <info>Installing tailwind...</info>\n");

        if (!sprout()->npm()->install('@leafphp/vite-plugin vite tailwindcss @tailwindcss/vite')) {
            $this->writeln('❌  <error>Failed to install tailwind</error>');
            return 1;
        }

        sprout()->process('npm install -D tailwindcss-animate')->run();

        $this->writeln("\n✅  <info>Tailwind CSS installed successfully</info>");
        $this->writeln("🧱  <info>Setting up Leaf server bridge...</info>\n");

        $success = sprout()->composer()->install('leafs/vite');

        if (!$success) {
            $this->writeln('❌  <error>Failed to setup Leaf server bridge</error>');
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
            \Leaf\FS\File::write("$directory/app/views/css/app.css", function ($content) {
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

        $this->writeln("\n🎉  <info>Tailwind CSS setup successfully</info>");
        $this->writeln("👉  Get started with the following commands:\n");
        $this->writeln('    php leaf serve <info>- start dev server</info>');
        $this->writeln("    php leaf view:build <info>- build for production</info>\n");

        return 0;
    }

    /**
     * Install vue
     */
    protected function installVue()
    {
        $this->writeln("📦  <info>Installing Vue...</info>\n");

        $directory = getcwd();

        if (!sprout()->npm()->install('@leafphp/vite-plugin @vitejs/plugin-vue @inertiajs/vue3@^1.0 vue vite tailwindcss @tailwindcss/vite')) {
            $this->writeln('❌  <error>Failed to install Vue</error>');
            return 1;
        }

        sprout()->npm()->install('-D tailwindcss-animate prettier prettier-plugin-organize-imports prettier-plugin-tailwindcss eslint eslint-config-prettier eslint-plugin-vue');

        $this->writeln("\n✅  <info>Vue installed successfully</info>");
        $this->writeln("🧱  <info>Setting up Leaf Vue server bridge...</info>\n");

        if (!sprout()->composer()->install('leafs/inertia leafs/vite')) {
            $this->writeln('❌  <error>Failed to setup Leaf Vue server bridge</error>');
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

        if (\Leaf\FS\File::exists("$directory/vite.config.js")) {
            \Leaf\FS\File::write("$directory/vite.config.js", function ($content) {
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

        if (\Leaf\FS\File::exists("$directory/app/routes/_app.php")) {
            \Leaf\FS\File::write("$directory/app/routes/_app.php", function ($content) {
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
            \Leaf\FS\File::write("$directory/app/views/css/app.css", function ($content) {
                if (strpos($content, '@import "tailwindcss";') === false) {
                    return "@import \"tailwindcss\";\n@source \"../\";\n\n$content";
                }

                return $content;
            });
        }

        $this->writeln("\n⚛️   <info>Vue setup successfully</info>");
        $this->writeln("👉  Get started with the following commands:\n");
        $this->writeln('    php leaf serve <info>- start dev server</info>');
        $this->writeln("    php leaf view:build <info>- build for production</info>\n");

        return 0;
    }
}

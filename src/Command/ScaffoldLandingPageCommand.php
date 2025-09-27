<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;

class ScaffoldLandingPageCommand extends Command
{
    protected $signature = 'scaffold:landing-page
        {--s|scaffold=default : Which scaffold to use for authentication (default/react/vue/svelte)}';
    protected $description = 'Scaffold landing page for your app';
    protected $help = 'Create basic views, components and assets for your landing page';

    protected function handle()
    {
        $directory = getcwd();
        $scaffold = $this->option('scaffold');

        if (!in_array($scaffold, ['default', 'react', 'vue', 'svelte'])) {
            $this->error("Invalid scaffold $scaffold. Available scaffolds are default, react, vue, svelte.");
            return 1;
        }

        if (\Leaf\FS\File::exists("$directory/app/views/_inertia.blade.php")) {
            $content = \Leaf\FS\File::read("$directory/app/views/_inertia.blade.php");

            if (strpos($content, '.jsx') !== false) {
                $scaffold = 'react';
            } else if (strpos($content, '.svelte') !== false) {
                $scaffold = 'svelte';
            } else if (strpos($content, '.vue') !== false) {
                $scaffold = 'vue';
            }
        }

        $this->comment("Scaffolding landing page using $scaffold scaffold...");

        if ($scaffold === 'default') {
            sprout()->composer()->install('leafs/zero');
            $this->writeln(shell_exec('php leaf view:install --tailwind'));
        }

        \Leaf\FS\Directory::copy(
            __DIR__ . '/themes/landing-page/' . $scaffold,
            getcwd(),
            ['recursive' => true]
        );

        if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.jsx")) {
            \Leaf\FS\File::delete("$directory/app/views/js/pages/welcome.jsx");
        } else if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.svelte")) {
            \Leaf\FS\File::delete("$directory/app/views/js/pages/welcome.svelte");
        } else if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.vue")) {
            \Leaf\FS\File::delete("$directory/app/views/js/pages/welcome.vue");
        }

        \Leaf\FS\Directory::delete("$directory/app/views/components/welcome", [
            'recursive' => true
        ]);

        \Leaf\FS\Directory::delete("$directory/app/views/js/components/welcome", [
            'recursive' => true
        ]);

        \Leaf\FS\File::write("$directory/app/routes/_app.php", function ($content) {
            $content = str_replace(
                "inertia('/', 'welcome', [
    'phpVersion' => PHP_VERSION
]",
                "inertia('/', 'index');
app()->inertia('/pricing', 'pricing'",
                $content
            );

            return str_replace(
                "app()->view('/', 'index');",
                "app()->view('/', 'pages.index');
app()->view('/pricing', 'pages.pricing');",
                $content
            );
        });

        $this->info('Landing page generated successfully.');

        return 0;
    }
}

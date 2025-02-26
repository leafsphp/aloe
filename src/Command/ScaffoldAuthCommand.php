<?php

namespace Aloe\Command;

use Aloe\Installer;

class ScaffoldAuthCommand extends \Aloe\Command
{
    protected static $defaultName = 'scaffold:auth';
    public $description = 'Scaffold basic app authentication';
    public $help = 'Create basic views, routes and controllers for authentication';

    protected function config()
    {
        $this
            ->setOption('scaffold', 's', 'optional', 'Which scaffold to use for authentication (default/api/react/vue/svelte)', 'default');
    }

    protected function handle()
    {
        $directory = getcwd();
        $scaffold = $this->option('scaffold');

        if (!in_array($scaffold, ['default', 'api', 'react', 'vue', 'svelte'])) {
            $this->error("Invalid scaffold $scaffold. Available scaffolds are default, api, react, vue, svelte.");
            return 1;
        }

        if (\Leaf\Core::mode() === 'api') {
            $scaffold = 'api';
        } else if (\Leaf\FS\File::exists("$directory/app/views/_inertia.blade.php")) {
            $content = \Leaf\FS\File::read("$directory/app/views/_inertia.blade.php");

            if (strpos($content, '.jsx') !== false) {
                $scaffold = 'react';
            } else if (strpos($content, '.svelte') !== false) {
                $scaffold = 'svelte';
            } else if (strpos($content, '.vue') !== false) {
                $scaffold = 'vue';
            }
        }

        $this->comment("Installing leaf auth using $scaffold scaffold...");

        Installer::installPackages('auth');
        Installer::magicCopy(__DIR__ . '/themes/auth/' . $scaffold);

        if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.jsx")) {
            \Aloe\Core::run("npm install class-variance-authority clsx tailwind-merge lucide-react @radix-ui/react-separator @radix-ui/react-tooltip @radix-ui/react-dialog @radix-ui/react-avatar @radix-ui/react-dropdown-menu @radix-ui/react-navigation-menu", $this->output);

            \Leaf\FS\File::write("$directory/app/views/js/pages/welcome.jsx", function ($content) {
                return str_replace(
                    ['{/* <Navbar auth={auth} /> */}', '// import Navbar from'],
                    ['<Navbar auth={auth} />', 'import Navbar from'],
                    $content
                );
            });
        } else if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.svelte")) {
            \Aloe\Core::run("npm install class-variance-authority clsx tailwind-merge lucide-svelte @tailwindcss/forms", $this->output);

            \Leaf\FS\File::write("$directory/app/views/js/pages/welcome.svelte", function ($content) {
                return str_replace(
                    ['<!-- <Navbar /> -->', '// import Navbar from'],
                    ['<Navbar auth={auth} />', 'import Navbar from'],
                    $content
                );
            });
        } else if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.vue")) {
            \Aloe\Core::run("npm install class-variance-authority clsx tailwind-merge lucide-vue-next @headlessui/vue @tailwindcss/forms @vueuse/core radix-vue", $this->output);

            \Leaf\FS\File::write("$directory/app/views/js/pages/welcome.vue", function ($content) {
                return str_replace(
                    ['<!-- <Navbar /> -->', '// import Navbar from'],
                    ['<Navbar :auth="$page.props.auth" />', 'import Navbar from'],
                    $content
                );
            });
        }

        $this->info('Authentication generated successfully.');

        return 0;
    }
}

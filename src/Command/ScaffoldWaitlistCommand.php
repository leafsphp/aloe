<?php

namespace Aloe\Command;

use Aloe\Installer;

class ScaffoldWaitlistCommand extends \Aloe\Command
{
    protected static $defaultName = 'scaffold:waitlist';
    public $description = 'Scaffold waitlist for your app';
    public $help = 'Create basic views, components and assets for your waitlist';

    protected function config()
    {
        $this
            ->setOption('scaffold', 's', 'optional', 'Which scaffold to use for authentication (default/react/vue/svelte)', 'default');
    }

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

        $this->comment("Scaffolding Waitlist using $scaffold scaffold...");

        Installer::magicCopy(__DIR__ . '/themes/waitlist/' . $scaffold);

        if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.jsx")) {
            \Leaf\FS\File::delete("$directory/app/views/js/pages/welcome.jsx");
        } else if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.svelte")) {
            \Leaf\FS\File::delete("$directory/app/views/js/pages/welcome.svelte");
        } else if (\Leaf\FS\File::exists("$directory/app/views/js/pages/welcome.vue")) {
            \Leaf\FS\File::delete("$directory/app/views/js/pages/welcome.vue");
        }

        if (\Leaf\FS\File::exists("$directory/app/controllers/Auth/RegisterController.php")) {
            \Leaf\FS\File::write("$directory/app/controllers/Auth/RegisterController.php", function ($content) {
                $content = str_replace(
                    'request()->validate([',
                    "request()->validate([
            'invite' => 'optional|string',",
                    $content
                );

                return str_replace(
                    '$success = auth()->register($credentials);',
                    "// update waitlist with registration date
        if (isset(\$credentials['invite'])) {
            \$decodedToken = (array) \Firebase\JWT\JWT::decode(
                \$credentials['invite'],
                new \Firebase\JWT\Key(\Leaf\Auth\Config::get('token.secret') . '-waitlist', 'HS256')
            );

            if (isset(\$decodedToken['user.email'])) {
                if (\$decodedToken['user.email'] !== \$credentials['email']) {
                    return response()
                        ->withFlash('form', request()->body())
                        ->withFlash('error', ['email' => 'Email does not match the invite token.'])
                        ->redirect(\"/auth/register?invite={\$credentials['invite']}\", 303);
                }

                db()
                    ->update('waitlist_emails')
                    ->params([
                        'registered_at' => date('Y-m-d H:i:s'),
                    ])
                    ->where('email', \$decodedToken['user.email'])
                    ->execute();

                db()->delete('waitlist_invites')
                    ->where('token', \$credentials['invite'])
                    ->execute();
            }

            unset(\$credentials['invite']);
        }

        \$success = auth()->register(\$credentials);",
                    $content
                );
            });
        }

        \Leaf\FS\File::write("$directory/app/routes/index.php", function ($content) {
            if (strpos($content, 'waitlist') !== false) {
                return $content;
            }

            return str_replace(
                '// app()->use(ExampleMiddleware::class);',
                "app()->use(\App\Middleware\WaitlistMiddleware::class);
// app()->use(ExampleMiddleware::class);",
                $content
            );
        });

        \Leaf\FS\File::write("$directory/app/routes/_app.php", function ($content) {
            $content = str_replace(
                "inertia('/', 'welcome', [
    'phpVersion' => PHP_VERSION
]",
                "inertia('/', 'index'",
                $content
            );

            return str_replace(
                "app()->view('/', 'index');",
                "app()->view('/', 'pages.waitlist');",
                $content
            );
        });

        \Aloe\Core::run('php leaf db:migrate waitlist_emails', $this->output);
        \Aloe\Core::run('php leaf db:migrate waitlist_invites', $this->output);

        $this->info('Waitlist generated successfully.');

        return 0;
    }
}

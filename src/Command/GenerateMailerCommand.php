<?php

namespace Aloe\Command;

use Leaf\Sprout\Command;
use Illuminate\Support\Str;

class GenerateMailerCommand extends Command
{
    protected $signature = 'g:mailer {mailer : The name of the mailer}';
    protected $description = 'Create a new mailer';
    protected $help = 'Create a new mailer';

    protected function handle()
    {
        $mailer = Str::studly(Str::singular($this->argument('mailer')));

        if (!strpos($mailer, 'Mailer')) {
            $mailer .= 'Mailer';
        }

        $mailerFile = getcwd() . AppPaths('mail') . "/$mailer.php";

        if (file_exists($mailerFile)) {
            $this->error("$mailer already exists");
            return 1;
        }

        if (!is_dir(dirname($mailerFile))) {
            mkdir(dirname($mailerFile), 0777, true);
        }

        \Leaf\FS\File::create($mailerFile, function () use ($mailer) {
            $fileContent = \file_get_contents(__DIR__ . '/stubs/mailer.stub');
            $fileContent = str_replace(
                'ClassName',
                $mailer,
                $fileContent
            );

            return $fileContent;
        }, ['recursive' => true]);

        $this->comment("$mailer generated successfully");

        return 0;
    }
}

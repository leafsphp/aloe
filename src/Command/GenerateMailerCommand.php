<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateMailerCommand extends Command
{
    protected static $defaultName = 'g:mailer';
    public $description = 'Create a new mailer';
    public $help = 'Create a new mailer';

    protected function config()
    {
        $this->setArgument('mailer', 'required', 'mailer name');
    }

    protected function handle()
    {
        $mailer = Str::studly(Str::singular($this->argument('mailer')));

        if (!strpos($mailer, 'Mailer')) {
            $mailer .= 'Mailer';
        }

        $file = Config::rootpath(AppPaths('mail') . "/$mailer.php");

        if (file_exists($file)) {
            $this->error("$mailer already exists");
            return 1;
        }

        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        touch($file);

        $fileContent = \file_get_contents(__DIR__ . '/stubs/mailer.stub');
        $fileContent = str_replace(
            'ClassName',
            $mailer,
            $fileContent
        );
        file_put_contents($file, $fileContent);

        $this->comment("$mailer generated successfully");

        return 0;
    }
}

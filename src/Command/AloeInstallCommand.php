<?php

namespace Aloe\Command;

class AloeInstallCommand extends \Aloe\Command
{
    protected static $defaultName = 'aloe:config';
    public $description = 'Install aloe config';
    public $help = 'Set up aloe CLI files in project';

    protected function handle()
    {
        $this->writeln('Installing aloe config');
        $aloe = Config::rootpath('leaf');
        $config = Config::configPath('aloe.php');
        $aloeContent = file_get_contents($aloe);

        if (file_exists($aloe) && ($this->check($aloeContent, 'new \Aloe\Console') && $this->check($aloeContent, 'Aloe\Console::boot()'))) {
            $overwrite = $this->confirm(asInfo('Aloe not found in console, install aloe?'));

            if ($overwrite) {
                unlink($aloe);
                $this->writeln(asComment('>') . ' Leaf Console tool removed successfully');
                copy(dirname(__DIR__) . '/Install/leaf', $aloe);
                $this->writeln(asComment('>') . ' Aloe CLI added successfully');
            }
        }

        $this->writeln(asComment('>') . ' Generating Aloe config...');

        if (file_exists($config)) {
            $overwrite = $this->confirm(asInfo('Aloe config already exists, overwrite file?'));

            if (!$overwrite) {
                $this->writeln(asComment('>') . ' Skipping Aloe config...');
                return $this->comment('Aloe CLI successfully installed!');
            }
        }

        copy(dirname(__DIR__) . '/Install/aloe.php', $config);
        $this->writeln(asComment('>') . ' Aloe config added successfully');

        $this->comment('Aloe CLI successfully installed!');
    }

    protected function check($file, $text)
    {
        return (strpos($file, $text) === false);
    }
}

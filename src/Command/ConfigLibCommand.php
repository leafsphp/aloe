<?php

namespace Aloe\Command;

use Aloe\Command;

class ConfigLibCommand extends Command
{
    protected static $defaultName = 'config:lib';
    public $description = 'Setup Leaf MVC to use external libraries';
    public $help = 'Setup Leaf MVC to use external libraries';

    protected function handle()
    {
        if (!\Leaf\FS\Directory::exists(LibPath())) {
            \Leaf\FS\Directory::create(LibPath());
        }

        $publicIndex = trim(PublicPath('index.php'), '/');

        \Leaf\FS\File::write($publicIndex, function ($content) {
            $content = str_replace(
                '// \Leaf\Core::loadLibs()',
                '\Leaf\Core::loadLibs()',
                $content
            );

            return $content;
        });

        $this->comment('lib folder setup successfully!');

        return 0;
    }
}

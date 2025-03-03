<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class DeleteSchemaCommand extends Command
{
    protected static $defaultName = 'd:schema';
    public $description = 'Delete a schema file';
    public $help = 'Delete a schema file';

    protected function config()
    {
        $this->setArgument('schema', 'required', 'The name of the console file');
    }

    protected function handle()
    {
        $schema = Str::lower($this->argument('schema'));

        if (strpos($schema, 'schema')) {
            $schema = str::plural(str_replace('Schema', '', $schema));
        }

        $file = Config::rootpath(DatabasePath("$schema.yml"));

        if (!\Leaf\FS\File::exists($file)) {
            $this->error("$schema doesn't exist!");
            return 1;
        }

        if (!\Leaf\FS\File::delete($file)) {
            $this->error("Couldn't delete $file, you might need to remove it manually.");
            return 1;
        }

        $this->comment("$schema deleted successfully");

        if (\Leaf\FS\Directory::isEmpty($dirname = dirname($file))) {
            if ($this->confirm(asError("> $dirname is empty. Delete folder?"))) {
                if (\Leaf\FS\Directory::delete($dirname)) {
                    $this->comment("$dirname deleted successfully!");
                }
            }
        }

        return 0;
    }
}

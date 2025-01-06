<?php

namespace Aloe\Command;

use Aloe\Command;
use Illuminate\Support\Str;

class GenerateSchemaCommand extends Command
{
    protected static $defaultName = 'g:schema';
    public $description = 'Create a new schema file';
    public $help = 'Generate a new database schema file';

    protected function config()
    {
        $this
            ->setArgument('schema', 'required', 'schema name')
            ->setOption('all', 'a', 'none', 'Create a model and controller for schema file')
            ->setOption('model', 'm', 'none', 'Create a model for your schema file')
            ->setOption('controller', 'c', 'none', 'Create a controller for your schema file');
    }

    protected function handle()
    {
        $schema = Str::lower($this->argument('schema'));

        if (strpos($schema, 'schema')) {
            $schema = str::plural(str_replace('Schema', '', $schema));
        }

        $schemaFile = Config::rootpath(DatabasePath("$schema.yml"));

        if (file_exists($schemaFile)) {
            $this->error("$schema already exists");

            return 1;
        }

        if (
            \Leaf\FS\File::create($schemaFile, function () {
                return file_get_contents(__DIR__ . '/stubs/schema.stub');
            })
        ) {
            $this->comment("$schema schema file created successfully!");

            // $this->generateExtraFiles($schema);
        }

        return 0;
    }

    protected function generateExtraFiles($modelName)
    {
        if ($this->option('all')) {
            $process = $this->runProcess(['php', 'leaf', 'g:model', $modelName, '-m']);

            $this->comment(
                $process === 0 ?
                'Model & Migration generated successfully!' :
                asError('Couldn\'t generate files')
            );

            if (Config::$env === 'WEB') {
                $process = $this->runProcess(['php', 'leaf', 'g:template', $modelName]);
                $this->comment(
                    $process === 0 ?
                    'Template generated successfully!' :
                    asError('Couldn\'t generate template')
                );
            }

            return $process;
        } else {
            if ($this->option('model')) {
                $process = $this->runProcess(['php', 'leaf', 'g:model', $modelName]);
                $this->comment(
                    $process === 0 ?
                    'Model generated successfully!' :
                    asError('Couldn\'t generate model')
                );

                return $process;
            }

            if ($this->option('template')) {
                $process = $this->runProcess(['php', 'leaf', 'g:template', $modelName]);
                $this->comment(
                    $process === 0 ?
                    'Template generated successfully!' :
                    asError('Couldn\'t generate template')
                );

                return $process;
            }
        }
    }
}

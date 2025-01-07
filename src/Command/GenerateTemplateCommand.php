<?php

namespace Aloe\Command;

class GenerateTemplateCommand extends \Aloe\Command
{
    protected static $defaultName = 'g:template';
    public $description = 'Create a new view file';
    public $help = 'Create a new basic view file';

    protected function config()
    {
        $this
            ->setAliases(['g:view'])
            ->setArgument('name', 'REQUIRED', 'The name of the template to create')
            ->setOption('type', 't', 'OPTIONAL', 'The type of template to create: jsx, vue, svelte, blade', 'blade');
    }

    protected function handle()
    {
        $templateName = strtolower($this->argument('name'));
        $templateName = $this->getTemplateName($templateName);
        $template = Config::rootpath(ViewsPath($templateName));

        storage()->createFile($template, function () {
            return str_replace(
                'pagename',
                \Illuminate\Support\Str::studly(basename($this->argument('name'))),
                $this->generateTemplateData()
            );
        });

        $this->comment("$templateName generated successfully");

        return 0;
    }

    protected function getTemplateName($templateName)
    {
        if ($this->option('type') === 'svelte') {
            $templateName = \Illuminate\Support\Str::studly($templateName) . '.svelte';
        } elseif ($this->option('type') === 'jsx') {
            $templateName = \Illuminate\Support\Str::studly($templateName) . '.jsx';
        } elseif ($this->option('type') === 'vue') {
            $templateName = \Illuminate\Support\Str::studly($templateName) . '.vue';
        } else {
            $templateName .= '.blade.php';
        }

        return $templateName;
    }

    protected function generateTemplateData()
    {
        $type = $this->option('type');
        $stub = \file_get_contents(__DIR__ . "/stubs/template/$type.stub");

        return $stub;
    }
}

<?php

namespace Aloe\Command;

class GenerateTemplateCommand extends \Aloe\Command
{
    protected static $defaultName = 'g:template';
    public $description = 'Create a new view file';
    public $help = 'Create a new basic view file';

    protected $type = 'blade';

    protected function config()
    {
        $this
            ->setAliases(['g:view'])
            ->setArgument('name', 'REQUIRED', 'The name of the template to create')
            ->setOption('type', 't', 'OPTIONAL', 'The type of template to create: jsx, vue, svelte, blade');
    }

    protected function handle()
    {
        $directory = Config::rootpath();

        if (\Leaf\FS\File::exists("$directory/app/views/_inertia.blade.php")) {
            $content = \Leaf\FS\File::read("$directory/app/views/_inertia.blade.php");

            if (strpos($content, '.jsx') !== false) {
                $this->type = 'react';
            } else if (strpos($content, '.svelte') !== false) {
                $this->type = 'svelte';
            } else if (strpos($content, '.vue') !== false) {
                $this->type = 'vue';
            }
        }

        if ($this->option('type')) {
            $this->type = $this->option('type');
        }

        $templateName = strtolower($this->argument('name'));
        $templateName = $this->getTemplateName($templateName);
        $template = Config::rootpath(ViewsPath(
            $this->type === 'blade' ? $templateName : "/js/$templateName"
        ));

        storage()->createFile($template, function () {
            return str_replace(
                'pagename',
                \Illuminate\Support\Str::studly(basename($this->argument('name'))),
                $this->generateTemplateData()
            );
        }, ['recursive' => true]);

        $this->comment("$templateName generated successfully");

        return 0;
    }

    protected function getTemplateName($templateName)
    {
        if ($this->type !== 'blade') {
            $templateName = implode('/', array_map('ucfirst', explode('/', $templateName)));
        }

        return $this->type === 'blade'
            ? "$templateName.blade.php"
            : ($this->type === 'react'
                ? "$templateName.jsx" : ("$templateName.{$this->type}"));
    }

    protected function generateTemplateData()
    {
        $type = $this->type;
        $stub = \file_get_contents(__DIR__ . "/stubs/template/$type.stub");

        return $stub;
    }
}

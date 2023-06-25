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
            ->setArgument('name', 'REQUIRED', 'The name of the template to create')
            ->setOption('type', 't', 'OPTIONAL', 'The type of template to create: html, jsx, vue, blade', 'blade')
            ->setOption('style', 's', 'OPTIONAL', 'The style framework to apply: bootstrap', 'bootstrap');
    }

    protected function handle()
    {
        $templateName = strtolower($this->argument('name'));
        $templateName = $this->getTemplateName($templateName);
        $template = Config::rootpath(ViewsPath($templateName));

        $fileContents = str_replace(
            'pagename',
            \Illuminate\Support\Str::studly($this->argument('name')),
            $this->generateTemplateData()
        );

        file_put_contents($template, $fileContents);

        $this->comment("$templateName generated successfully");
        return 0;
    }

    protected function getTemplateName($templateName)
    {
        if ($this->option('type') === 'html') {
            $templateName .= '.html';
        } else if ($this->option('type') === 'jsx') {
            $templateName = \Illuminate\Support\Str::studly($templateName) . '.jsx';
        } else if ($this->option('type') === 'vue') {
            $templateName = \Illuminate\Support\Str::studly($templateName) . '.vue';
        } else {
            $templateName .= '.blade.php';
        }

        return $templateName;
    }

    protected function generateTemplateData()
    {
        $type = $this->option('type');
        $style = $this->option('style');
        $stub = \file_get_contents(__DIR__ . "/stubs/template/$type-$style.stub");

        return $stub;
    }
}

<?php

namespace Aloe\Command;

class GenerateTemplateCommand extends \Aloe\Command
{
    public $name = "g:template";
    public $description = "Create a new view file";
    public $help = "Create a new basic view file";

    public function config()
    {
        $this
            ->setArgument("name", "REQUIRED", "The name of the template to create")
            ->setOption("type", "t", "OPTIONAL", "The type of template to create: html, jsx, vue, blade", "blade")
            ->setOption("style", "s", "OPTIONAL", "The style framework to apply: bootstrap", "bootstrap");
    }

    public function handle()
    {
        $templateName = strtolower($this->argument("name"));
        $templateName = $this->getTemplateName($templateName);
        $template = Config::views_path($templateName);

        $fileContents = str_replace(
            "pagename",
            \Leaf\Str::studly($this->argument("name")),
            $this->generateTemplateData()
        );

        file_put_contents($template, $fileContents);

        $this->comment("$templateName generated successfully");
    }

    protected function getTemplateName($templateName)
    {
        if ($this->option("type") === "html") {
            $templateName .= ".html";
        } else if ($this->option("type") === "jsx") {
            $templateName = \Leaf\Str::studly($templateName) . ".jsx";
        } else if ($this->option("type") === "vue") {
            $templateName = \Leaf\Str::studly($templateName) . ".vue";
        } else {
            $templateName .= ".blade.php";
        }

        return $templateName;
    }

    protected function generateTemplateData()
    {
        $type = $this->option("type");
        $style = $this->option("style");
        $stub = \file_get_contents(__DIR__ . "/stubs/template/$type-$style.stub");

        return $stub;
    }
}

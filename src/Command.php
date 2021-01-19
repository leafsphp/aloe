<?php

namespace Aloe;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Process;

/**
 * Command Utilities for Aloe Commands
 * 
 * @author Michael Darko <mickdd22@gmail.com>
 */
abstract class Command extends SymfonyCommand
{
    /**
     * The name of command to run in console
     */
    public $name;

    /**
     * Description for command
     */
    public $description;

    /**
     * Help for command
     */
    public $help;

    /**
     * The input object
     * 
     * @var InputInterface
     */
    public $input;

    /**
     * The output object
     * 
     * @var OutputInterface
     */
    public $output;

    /**
     * Configure your command
     */
    protected function configure()
    {
        if ($this->name) {
            $this->setName($this->name);
        }

        if ($this->description) {
            $this->setDescription($this->description);
        }

        if ($this->help) {
            $this->setHelp($this->help);
        }

        $this->config();
    }

    /**
     * Configure command
     */
    public function config()
    {
        //
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->handle($input, $output);
    }

    /**
     * Scripts to run when command is used
     */
    public function handle()
    {
        //
    }

    // IO Features

    /**
     * Get an argument or return the input object
     * 
     * @param string $data The argument to return
     */
    public function input($data = null)
    {
        if (!$data) return $this->input;

        return $this->argument($data);
    }

    /**
     * Output data or return the output object
     * 
     * @param string $data The argument to return
     */
    public function output($data = null)
    {
        if (!$data) return $this->output;

        return $this->writeln($data);
    }

    /**
     * Add a new argument
     */
    public function setArgument($name, $mode = null, $description = "", $default = null)
    {
        if (strtoupper($mode) === "OPTIONAL") {
            $mode = InputArgument::OPTIONAL;
        }

        if (strtoupper($mode) === "REQUIRED") {
            $mode = InputArgument::REQUIRED;
        }

        if (strtoupper($mode) === "IS_ARRAY") {
            $mode = InputArgument::IS_ARRAY;
        }

        return $this->addArgument($name, $mode, $description, $default);
    }

    /**
     * Returns the argument value for a given argument name.
     */
    public function argument(string $name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * Returns all the given arguments merged with the default values.
     */
    public function arguments()
    {
        return $this->input->getArguments();
    }

    /**
     * Add a new option
     */
    public function setOption($name, $shortcut = null, $mode = null, $description = "", $default = null)
    {
        if (strtoupper($mode) === "OPTIONAL") {
            $mode = InputOption::VALUE_OPTIONAL;
        }

        if (strtoupper($mode) === "REQUIRED") {
            $mode = InputOption::VALUE_REQUIRED;
        }

        if (strtoupper($mode) === "NONE") {
            $mode = InputOption::VALUE_NONE;
        }

        if (strtoupper($mode) === "IS_ARRAY") {
            $mode = InputOption::VALUE_IS_ARRAY;
        }

        return $this->addOption($name, $shortcut, $mode, $description, $default);
    }

    /**
     * Get an input option
     */
    public function option(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * Get all input options
     */
    public function options(string $name)
    {
        return $this->input->getOptions($name);
    }

    /**
     * Ask a question
     */
    public function ask(string $question, $default = null)
    {
        $helper = $this->getHelper("question");
        $question = new Question("$question ", $default);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question
     */
    public function askRaw(string $question, $default = null)
    {
        $helper = $this->getHelper("question");
        $question = new Question("$question ", $default);

        $question->setTrimmable(false);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question
     */
    public function askMultiline(string $question)
    {
        $helper = $this->getHelper("question");
        $question = new Question("$question ");

        // $question->setMultiline(true);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question with auto completion
     */
    public function autoComplete(string $question, array $potentialAnswers, $default = null)
    {
        $helper = $this->getHelper("question");
        $question = new Question("$question ", $default);

        $question->setAutocompleterValues($potentialAnswers);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question with possible answers
     */
    public function choice(string $question, array $choices, string $errorMessage = "Invalid choice", $default = 0)
    {
        $helper = $this->getHelper("question");
        $question = new ChoiceQuestion("$question ", $choices, $default);

        $question->setErrorMessage($errorMessage);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question with possible answers + multiple choice
     */
    public function multiChoice(string $question, array $choices, string $errorMessage = "Invalid choice", $default = 0)
    {
        $helper = $this->getHelper("question");
        $question = new ChoiceQuestion("$question ", $choices, $default);

        $question->setMultiselect(true);
        $question->setErrorMessage($errorMessage);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Prompt user for input but hide keystrokes
     */
    public function secret(string $question, bool $useFallback = false)
    {
        $helper = $this->getHelper("question");
        $question = new Question("$question ");

        $question->setHidden(true);
        $question->setHiddenFallback($useFallback);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Prompt user for confirmation
     */
    public function confirm($question, $param = false, $regex = "/^y/i")
    {
        $helper = $this->getHelper("question");
        $question = new ConfirmationQuestion("$question ", $param, $regex);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Output some data
     */
    public function write($messages, $options = 0)
    {
        return $this->output->write($messages, $options);
    }

    /**
     * Output some data
     */
    public function writeln($messages, $options = 0)
    {
        return $this->output->writeln($messages, $options);
    }

    // output styles

    /**
     * Output some data as a comment
     */
    public function comment($messages, $options = 0)
    {
        return $this->writeln("<comment>$messages</comment>", $options);
    }

    /**
     * Output some data as a info
     */
    public function info($messages, $options = 0)
    {
        return $this->writeln("<info>$messages</info>", $options);
    }

    /**
     * Output some data as a error
     */
    public function error($messages, $options = 0)
    {
        return $this->writeln("<error>$messages</error>", $options);
    }

    /**
     * Output some data as a question
     */
    public function question($messages, $options = 0)
    {
        return $this->writeln("<question>$messages</question>", $options);
    }

    /**
     * Output some data as a link
     */
    public function link($link, $display, $options = 0)
    {
        return $this->writeln("<href=$link>$display</>", $options);
    }

    // misc features

    /**
     * Run a new cli process
     */
    public function runProcess(string $process)
    {
        $process = new Process($process);
        return $process->run();
    }
}

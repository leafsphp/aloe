<?php

namespace Aloe;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Process;

/**
 * Base class for Aloe Commands.
 * 
 * @author Michael Darko <mickdd22@gmail.com>
 */
class Command extends BaseCommand
{
    /**
     * @var string|null The default command name
     */
    protected static $defaultName;

    /**
     * The name of command to run in console
     */
    private $name;

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
    protected $input;

    /**
     * The output object
     * 
     * @var OutputInterface
     */
    protected $output;

    private $application;
    private $processTitle;
    private $aliases = [];
    private $definition;
    private $hidden = false;
    private $fullDefinition;
    private $ignoreValidationErrors = false;
    private $code;
    private $synopsis = [];
    private $usages = [];
    private $helperSet;

    public const SUCCESS = 0;
    public const FAILURE = 1;

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setDescription($this->description);
        $this->setHelp($this->help);
        $this->config();
    }
    
    protected function config()
    {
        //
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->handle();
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @return int 0 if everything went fine, or an exit code
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function handle()
    {
        throw new LogicException('You must override the handle() method in the concrete command class.');
    }

    /**
     * Runs the command.
     *
     * The code to execute is either defined directly with the
     * setCode() method or by overriding the execute() method
     * in a sub-class.
     *
     * @return int The command exit code
     *
     * @throws \Exception When binding input fails. Bypass this by calling {@link ignoreValidationErrors()}.
     *
     * @see setCode()
     * @see execute()
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        // add the application arguments and options
        $this->mergeApplicationDefinition();

        // bind the input against the command specific arguments/options
        try {
            $input->bind($this->getDefinition());
        } catch (ExceptionInterface $e) {
            if (!$this->ignoreValidationErrors) {
                throw $e;
            }
        }

        $this->initialize($input, $output);

        if (null !== $this->processTitle) {
            if (\function_exists('cli_set_process_title')) {
                if (!@cli_set_process_title($this->processTitle)) {
                    if ('Darwin' === \PHP_OS) {
                        $this->comment('Running "cli_set_process_title" as an unprivileged user is not supported on MacOS.', OutputInterface::VERBOSITY_VERY_VERBOSE);
                    } else {
                        cli_set_process_title($this->processTitle);
                    }
                }
            } elseif (\function_exists('setproctitle')) {
                \setproctitle($this->processTitle);
            } elseif (OutputInterface::VERBOSITY_VERY_VERBOSE === $output->getVerbosity()) {
                $this->comment('Install the proctitle PECL to be able to change the process title.');
            }
        }

        if ($input->isInteractive()) {
            $this->interact($input, $output);
        }

        // The command name argument is often omitted when a command is executed directly with its run() method.
        // It would fail the validation if we didn't make sure the command argument is present,
        // since it's required by the application.
        if ($input->hasArgument('command') && null === $input->getArgument('command')) {
            $input->setArgument('command', $this->getName());
        }

        $input->validate();

        if ($this->code) {
            $statusCode = ($this->code)($input, $output);
        } else {
            $statusCode = $this->execute($input, $output);

            // if (!\is_int($statusCode)) {
            //     throw new \TypeError(sprintf('Return value of "%s::execute()" must be of the type int, "%s" returned.', static::class, get_debug_type($statusCode)));
            // }
        }

        return is_numeric($statusCode) ? (int) $statusCode : 0;
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
        if (strtoupper($mode) === 'OPTIONAL') {
            $mode = InputArgument::OPTIONAL;
        }

        if (strtoupper($mode) === 'REQUIRED') {
            $mode = InputArgument::REQUIRED;
        }

        if (strtoupper($mode) === 'IS_ARRAY') {
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
    public function setOption($name, $shortcut = null, $mode = null, $description = '', $default = null)
    {
        if (strtoupper($mode) === 'OPTIONAL') {
            $mode = InputOption::VALUE_OPTIONAL;
        }

        if (strtoupper($mode) === 'REQUIRED') {
            $mode = InputOption::VALUE_REQUIRED;
        }

        if (strtoupper($mode) === 'NONE') {
            $mode = InputOption::VALUE_NONE;
        }

        if (strtoupper($mode) === 'IS_ARRAY') {
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
        $helper = $this->getHelper('question');
        $question = new Question("$question ", $default);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question
     */
    public function askRaw(string $question, $default = null)
    {
        $helper = $this->getHelper('question');
        $question = new Question("$question ", $default);

        $question->setTrimmable(false);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question
     */
    public function askMultiline(string $question)
    {
        $helper = $this->getHelper('question');
        $question = new Question("$question ");

        // $question->setMultiline(true);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question with auto completion
     */
    public function autoComplete(string $question, array $potentialAnswers, $default = null)
    {
        $helper = $this->getHelper('question');
        $question = new Question("$question ", $default);

        $question->setAutocompleterValues($potentialAnswers);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question with possible answers
     */
    public function choice(string $question, array $choices, string $errorMessage = "Invalid choice", $default = 0)
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion("$question ", $choices, $default);

        $question->setErrorMessage($errorMessage);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Ask a question with possible answers + multiple choice
     */
    public function multiChoice(string $question, array $choices, string $errorMessage = "Invalid choice", $default = 0)
    {
        $helper = $this->getHelper('question');
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
        $helper = $this->getHelper('question');
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
        $helper = $this->getHelper('question');
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
    public function runProcess(array $process)
    {
        $process = new Process($process);
        return $process->run();
    }
}

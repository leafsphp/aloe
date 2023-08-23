<?php

declare(strict_types=1);

namespace Aloe\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class KeyGenerateCommand extends Command
{
	protected static $defaultName = 'key:generate';

	protected function configure()
	{
		$this
			->setHelp('Run your frontend dev command')
			->setDescription('Run your frontend dev server');
	}

	protected function generateKey()
	{
		return 'base64:' . base64_encode(random_bytes(32));
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$directory = getcwd();
		$env = file_get_contents("$directory/.env");

		if (strpos($env, 'APP_KEY') !== false) {
			$output->writeln("<info>APP_KEY already exists. Regenerating APP_KEY</info>");
			$env = preg_replace('/APP_KEY=(.*)/', "APP_KEY={$this->generateKey()}", $env);
		} else {
			$env = "APP_KEY={$this->generateKey()}\n$env";
		}


		file_put_contents("$directory/.env", $env);

		$output->writeln("<info>APP_KEY generated successfully.</info>");

		return 0;
	}
}

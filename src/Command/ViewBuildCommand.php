<?php

declare(strict_types=1);

namespace Aloe\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewBuildCommand extends Command
{
	protected static $defaultName = 'view:build';

	protected function configure()
	{
		$this
			->setHelp('Run your frontend dev command')
			->setDescription('Run your frontend dev server');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$npm = \Aloe\Core::findNpm();
		$success = \Aloe\Core::run("$npm run build", $output);

		if (!$success) return 1;

		return 0;
	}
}

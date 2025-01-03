<?php

namespace Arman\LaravelSwagger\Console;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class SwaggerWatch extends Command {

	protected $signature = 'swagger:watch';
	protected $description = 'Watch controller file';

	private string|null $lastChecksum = null;

	public function handle() {
		$paths = config('swagger.watch', []);

		if (empty($paths)) {
			$this->error('No paths defined in config file');
			return;
		}

		$this->runSwaggerGenerator();

		while (true) {
			$currentChecksum = $this->getControllersChecksum($paths);

			if ($this->lastChecksum !== null && $this->lastChecksum !== $currentChecksum) {
				$this->runSwaggerGenerator();
			}

			$this->lastChecksum = $currentChecksum;
			sleep(2);
		}
	}

	private function getControllersChecksum(array $paths): string {
		$finder = new Finder();
		$checksums = [];

		$finder->files()
			->in($paths)
			->name('*.php')
			->ignoreDotFiles(true)
			->ignoreVCS(true);

		foreach ($finder as $file) {
			$checksums[] = md5_file($file->getRealPath());
		}

		return md5(implode('', $checksums));
	}

	private function runSwaggerGenerator(): void {
		$command = ['php', 'artisan', 'swagger:generate'];

		$process = new Process($command);

		$process->run();

		if (!$process->isSuccessful()) {
			echo "\033[31m" . $process->getOutput() . "\033[0m";
		} else {
			echo "\033[32m" . $process->getOutput() . "\033[0m";
		}
	}
}

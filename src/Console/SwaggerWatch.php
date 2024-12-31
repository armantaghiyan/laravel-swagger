<?php

namespace Arman\LaravelSwagger\Console;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

class SwaggerWatch extends Command {

	protected $signature = 'swagger:watch';
	protected $description = 'Watch controller file';

	private $lastChecksum = null;

	public function handle() {
		$this->runSwaggerGenerator();
		while (true) {
			$currentChecksum = $this->getControllersChecksum();

			if ($this->lastChecksum !== null && $this->lastChecksum !== $currentChecksum) {
				$this->runSwaggerGenerator();
			}

			$this->lastChecksum = $currentChecksum;
			sleep(2);
		}
	}

	private function getControllersChecksum() {
		$finder = new Finder();
		$checksums = [];

		$finder->files()->in(app_path('Http/Controllers'))->name('*.php');

		foreach ($finder as $file) {
			$checksums[] = md5_file($file->getRealPath());
		}

		return md5(implode('', $checksums));
	}

	private function runSwaggerGenerator() {
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

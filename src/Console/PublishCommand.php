<?php

namespace Arman\LaravelSwagger\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command {

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'swagger:publish {--force : Overwrite any existing files}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publish all of the swagger resources';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle(): void {
		$this->call('vendor:publish', [
			'--tag' => 'swagger-config',
			'--force' => $this->option('force'),
		]);

		$this->call('vendor:publish', [
			'--tag' => 'swagger-assets',
			'--force' => true,
		]);
	}
}
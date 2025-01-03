<?php

namespace Arman\LaravelSwagger\Console;

use Illuminate\Console\Command;
use OpenApi\Generator;

class SwaggerGenerate extends Command {

	protected $signature = 'swagger:generate';
	protected $description = 'Generate swagger documentation';

	public function handle(): void {
		$outputDir = config('swagger.save_path');
		$paths = config('swagger.watch', []);

		if (empty($paths)) {
			$this->error('No paths defined in config file');
			return;
		}

		if (!is_dir($outputDir)) {
			mkdir($outputDir, 0755, true);
		}

		$openapi = Generator::scan($paths);
		file_put_contents("$outputDir/swagger.json", $openapi->toJson());

		$this->info('Swagger documentation generated successfully.');
	}
}

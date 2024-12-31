<?php

namespace Arman\LaravelSwagger\Console;

use Illuminate\Console\Command;
use OpenApi\Generator;

class SwaggerGenerate extends Command {

	protected $signature = 'swagger:generate';
	protected $description = 'Generate swagger documentation';

	public function handle(): void {
		$outputDir = storage_path('docs');
		$scanDir = app_path('Http/Controllers');

		if (!is_dir($outputDir)) {
			mkdir($outputDir, 0755, true);
		}

		$openapi = Generator::scan([$scanDir]);
		file_put_contents("$outputDir/swagger.json", $openapi->toJson());

		$this->info('Swagger documentation generated successfully.');
	}
}

<?php


namespace Arman\LaravelSwagger;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelSwaggerServiceProvider extends ServiceProvider {

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->mergeConfigFrom(
			__DIR__ . '/../config/swagger.php', 'swagger'
		);
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot(): void {
		$this->registerCommands();
		$this->registerPublishing();
		$this->registerRoutes();
		$this->registerResources();
	}

	/**
	 * Register the package's commands.
	 *
	 * @return void
	 */
	protected function registerCommands(): void {
		if ($this->app->runningInConsole()) {
			$this->commands([
				Console\SwaggerGenerate::class,
				Console\PublishCommand::class,
				Console\SwaggerWatch::class,
			]);
		}
	}

	/**
	 * Register the package routes.
	 *
	 * @return void
	 */
	protected function registerRoutes(): void {
		Route::group([
			'domain' => config('swagger.domain'),
			'prefix' => config('swagger.prefix'),
		], function () {
			$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
		});
	}

	/**
	 * Register the laravel swagger resources.
	 *
	 * @return void
	 */
	protected function registerResources(): void {
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'swagger');
	}

	/**
	 * Register the package's publishable resources.
	 *
	 * @return void
	 */
	protected function registerPublishing(): void {
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../config/swagger.php' => config_path('swagger.php'),
			], 'swagger-config');

			$this->publishes([
				__DIR__ . '/../public' => public_path('vendor/swagger'),
			], ['swagger-assets', 'laravel-assets']);
		}
	}
}

<?php

namespace Arman\LaravelSwagger\Export;

use Illuminate\Support\Facades\Route;

class SwaggerExport {

	private $data = [
		'openapi' => "3.0.0",
		'info' => [],
		'paths' => []
	];

	/**
	 * @throws \ReflectionException
	 */
	public function __construct() {
		$this->setBasicDataFromConfig();
		$this->crawlRoutes();
	}

	private function setBasicDataFromConfig() {
		$this->data['info']['title'] = config('swagger.title', 'Laravel Swagger');
		$this->data['info']['version'] = config('swagger.version', '1.0.0');
	}

	/**
	 * @throws \ReflectionException
	 */
	public function crawlRoutes() {
		$routes = Route::getRoutes();

		foreach ($routes as $route) {
			$routeData = new RouteData($route);
			$uri = $routeData->getUri();
			$newPath = $routeData->get();

			$this->data['paths'][$uri] = isset($this->data['paths'][$uri]) ? array_merge($this->data['paths'][$uri], $newPath) : $newPath;
		}
	}

	public function toArray(): array {
		return $this->data;
	}

	public function toJson(): bool|string {
		return json_encode($this->data);
	}
}
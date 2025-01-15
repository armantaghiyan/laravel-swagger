<?php

namespace Arman\LaravelSwagger\Export;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use ReflectionClass;


class RouteData {
	private Route $route;

	private string $tag = 'Default';
	private string $uri;
	private string $method;
	private string $controller;
	private array $parameters = [];

	/**
	 * @throws \ReflectionException
	 */
	public function __construct(Route $route) {
		$this->route = $route;

		$this->getRouteData();

		$this->getSectionName();

		$this->getRouteParamData();
	}

	private function getRouteData(): void {
		$action = $this->route->getActionName();
		$uri = $this->route->uri();
		$uri = $uri[0] === '/' ? $uri : "/$uri";
		$controllerAndMethod = explode('@', $action);

		$this->uri = $uri;
		$this->method = Str::lower($this->route->methods()[0]);
		$this->controller = $controllerAndMethod[0];
	}

	/**
	 * @throws \ReflectionException
	 */
	private function getSectionName(): void {
		if ($this->controller !== 'Closure') {
			$instance = app($this->controller);
			$reflection = new ReflectionClass($instance);

			foreach ($reflection->getAttributes() as $attribute) {
				if ($attribute->getName() === 'Arman\LaravelSwagger\Attribute\Section') {
					$this->tag = $attribute->newInstance()->name;
				}
			}
		}
	}


	private function getRouteParamData(): void {
		$this->parameters = [];
		foreach ($this->route->parameterNames() as $parameterName) {
			$isOptional = str_contains($this->uri, "{{$parameterName}?}");

			$this->parameters[] = [
				'name' => $parameterName,
				'in' => 'path',
				'required' => !$isOptional,
				'description' => "The ID of the user",
				'schema' => [
					'type' => 'string',
				],
			];
		}
	}

	private function generateOperationId(string $uri, string $method): string {
		return hash('md5', $method . ':' . $uri);
	}

	public function getUri() {
		return str_replace('?', '', $this->uri);
	}

	public function get() {
		return [
			$this->method => [
				"tags" => [$this->tag],
				"operationId" => $this->generateOperationId($this->uri, $this->method),
				"parameters" => $this->parameters
			]
		];
	}
}
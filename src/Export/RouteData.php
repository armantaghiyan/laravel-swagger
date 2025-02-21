<?php

namespace Arman\LaravelSwagger\Export;

use Arman\LaravelSwagger\Attribute\ApiParam;
use Arman\LaravelSwagger\Attribute\ApiSummary;
use Arman\LaravelSwagger\Attribute\Section;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;


class RouteData {

	private Route $route;

	private string $tag = 'Default';
	private string $uri;
	private string $method;
	private string $controller;
	private mixed $controllerInstance;
	private string|null $controllerMethod;
	private array $parameters = [];
	private string $summary = '';

	/**
	 * @throws ReflectionException
	 */
	public function __construct(Route $route) {
		$this->route = $route;

		$this->getRouteData();

		$this->getRouteParamData();

		if (!$this->isClosure()) {
			$this->getSectionName();

			$this->getApiSummary();
		}
	}

	private function getRouteData(): void {
		$action = $this->route->getActionName();
		$uri = $this->route->uri();
		$uri = $uri[0] === '/' ? $uri : "/$uri";
		$controllerAndMethod = explode('@', $action);

		$this->uri = $uri;
		$this->method = Str::lower($this->route->methods()[0]);
		$this->controller = $controllerAndMethod[0];
		$this->controllerMethod = $controllerAndMethod[1] ?? null;

		if (!$this->isClosure()) {
			$this->controllerInstance = app($this->controller);
		}
	}

	/**
	 * @throws ReflectionException
	 */
	private function getSectionName(): void {
		$reflection = new ReflectionClass($this->controllerInstance);

		$attributes = $reflection->getAttributes(Section::class);
		if (!empty($attributes)) {
			$this->tag = $attributes[0]->newInstance()->name;
		}
	}

	/**
	 * @throws ReflectionException
	 */
	private function getApiSummary(): void {
		$reflection = new ReflectionMethod($this->controllerInstance, $this->controllerMethod);
		$attributes = $reflection->getAttributes(ApiSummary::class);

		if (!empty($attributes)) {
			$this->summary = $attributes[0]->newInstance()->summary;
		}
	}

	private function getRouteParamData(): void {
		foreach ($this->route->parameterNames() as $parameterName) {
			$isOptional = str_contains($this->uri, "{{$parameterName}?}");

			$this->parameters[] = [
				'name' => $parameterName,
				'in' => 'path',
				'required' => !$isOptional,
				'description' => '',
				'schema' => [
					'type' => 'string',
				],
			];
		}
	}

	private function generateOperationId(string $uri, string $method): string {
		return hash('md5', $method . ':' . $uri);
	}

	private function isClosure(): bool {
		return $this->controller === 'Closure';
	}

	public function getUri(): string {
		return str_replace('?', '', $this->uri);
	}

	public function get(): array {
		return [
			$this->method => [
				"operationId" => $this->generateOperationId($this->uri, $this->method),
				"tags" => [$this->tag],
				"parameters" => $this->parameters,
				"summary" => $this->summary,
				"responses" => []
			]
		];
	}
}
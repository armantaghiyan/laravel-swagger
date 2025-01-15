<?php

namespace Arman\LaravelSwagger\Export;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;


class RouteData {

	private Route $route;

	private string $tag = 'Default';
	private string $uri;
	private string $method;
	private string $controller;
	private string|null $controllerMethod;
	private array $parameters = [];
	private string $summary = '';

	/**
	 * @throws \ReflectionException
	 */
	public function __construct(Route $route) {
		$this->route = $route;

		$this->getRouteData();

		$this->getSectionName();

		$this->getRouteParamData();

		$this->getApiSummary();
	}

	private function getRouteData(): void {
		$action = $this->route->getActionName();
		$uri = $this->route->uri();
		$uri = $uri[0] === '/' ? $uri : "/$uri";
		$controllerAndMethod = explode('@', $action);

		$this->uri = $uri;
		$this->method = Str::lower($this->route->methods()[0]);
		$this->controller = $controllerAndMethod[0];
		$this->controllerMethod = $controllerAndMethod[1]??null;
	}

	private function getSectionName(): void {
		if (!$this->isClosure()) {
			$instance = app($this->controller);
			$reflection = new ReflectionClass($instance);
			$sectionAttribute = 'Arman\LaravelSwagger\Attribute\Section';

			$attributes = $reflection->getAttributes($sectionAttribute);
			if (!empty($attributes)) {
				$this->tag = $attributes[0]->newInstance()->name;
			}
		}
	}

	private function getApiSummary(): void {
		if (!$this->isClosure()) {
			$instance = app($this->controller);

			$sectionAttribute = 'Arman\LaravelSwagger\Attribute\ApiSummary';
			$reflection = new ReflectionMethod($instance, $this->controllerMethod);

			$attributes = $reflection->getAttributes($sectionAttribute);

			if (!empty($attributes)) {
				$this->summary = $attributes[0]->newInstance()->summary;
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

	private function isClosure() {
		return $this->controller === 'Closure';
	}

	public function getUri() {
		return str_replace('?', '', $this->uri);
	}

	public function get() {
		return [
			$this->method => [
				"operationId" => $this->generateOperationId($this->uri, $this->method),
				"tags" => [$this->tag],
				"parameters" => $this->parameters,
				"summary" => $this->summary
			]
		];
	}
}
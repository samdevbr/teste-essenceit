<?php
namespace App\Infrastructure\Routing;

use App\Infrastructure\Providers\RouteProvider;

class Router
{
	private $routeProvider;
	private $routeStack = [
		'GET' => [],
		'POST' => [],
	];

	private static $instance = null;

	public function __construct(RouteProvider $provider)
	{
		$this->routeProvider = $provider;
	}

	public function mapRoutes()
	{
		$this->routeProvider->register();
	}

	public function addRoute(Route $route)
	{
		$this->routeStack[$route->method][] = $route;
	}

	public function tryRoute(string $method, string $uri)
	{
		$routesForMethod = $this->routeStack[$method] ?? [];

		foreach ($routesForMethod as $route) {
			if ($route->matches($uri)) {

				if (class_exists($route->className)) {
					$class = new $route->className;

					$class->{$route->classMethod}();
				}
			}
		}
	}

	public static function make() : Router
	{
		if (!self::$instance) {
			self::$instance = new static(new RouteProvider);
			self::$instance->mapRoutes();
		}

		return self::$instance;
	}
}

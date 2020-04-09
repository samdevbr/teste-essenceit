<?php
namespace App\Infrastructure\Routing;

use App\Infrastructure\Http\Request;
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

	public function tryRoute(Request &$request)
	{
		$routesForMethod = $this->routeStack[$request->method()] ?? [];
		$validRoute = null;

		foreach ($routesForMethod as $route) {
			if ($route->matches($request->uri())) {
				$validRoute = $route;
				break;
			}
		}

		if ($validRoute) {
			preg_match_all($validRoute->uriRegex, $request->uri(), $matches);

			array_shift($matches);

			$args = [];
			for ($i = 0; $i < count($matches); $i++) {
				$value = $matches[$i][0];
				$key = $route->params[$i];

				$request->addParam($key, $value);
			}

			return $validRoute;
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

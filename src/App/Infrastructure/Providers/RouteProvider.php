<?php
namespace App\Infrastructure\Providers;

use App\Infrastructure\Contracts\IProvider;
use App\Domain\Quote\Providers\RouteProvider as QuoteRouteProvider;

class RouteProvider implements IProvider
{
	private $routes = [
		QuoteRouteProvider::class
	];

	public function register()
	{
		foreach ($this->routes as $route) {
			$provider = new $route();
			$provider->register();
		}
	}
}

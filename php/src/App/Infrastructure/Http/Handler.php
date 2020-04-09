<?php
namespace App\Infrastructure\Http;

use App\Infrastructure\Routing\Router;

class Handler
{
	private $request;
	private $router;

	public function __construct()
	{
		$this->request = Request::capture();
		$this->router = Router::make(
			$this->request
		);
	}

	public function handle()
	{
		$route = $this->router->tryRoute(
			$this->request
		);

		if (!$route) {
			Response::json(Response::HTTP_NOT_FOUND, [
				'error' => 'Route not found'
			]);
		} else {
			$class = $route->resolveClass();
			$class->{$route->classMethod}(...$this->request->getParams());
		}
	}
}

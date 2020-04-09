<?php

namespace App\Domain\Quote\Services;

class QuoteService
{
	/**
	 * @var RouteService $routeService
	 */
	private $routeService;

	public function __construct(RouteService $routeService)
	{
		$this->routeService = $routeService;
	}

	private function buildRoutingTree($routes, $takeoff)
	{
		$tree = [];

		foreach ($routes as $route) {
			if ($route["takeoff"] === $takeoff) {
				$connections = $this->buildRoutingTree($routes, $route["land"]);

				if ($connections) {
					$route['connections'] = $connections;
				}

				$tree[] = $route;
			}
		}

		return $tree;
	}

	private function popConnections($connection, array &$out)
	{
		$out[] = [
			'takeoff' => $connection['takeoff'],
			'land' => $connection['land'],
			'price' => $connection['price'],
		];

		if (isset($connection['connections'])) {
			foreach ($connection['connections'] as $conn) {
				$this->popConnections($conn, $out);
			}
		}
	}

	private function findPath(array $connections, $land)
	{
		$path = [
			$connections["takeoff"]
		];
		$price = $connections["price"];
		$found = false;

		foreach ($connections['connections'] as $connection) {
			$flattedConnections = [];

			$this->popConnections($connection, $flattedConnections);

			foreach ($flattedConnections as $flattedConnection) {
				if ($flattedConnection['land'] !== $land) {
					$path[] = $flattedConnection["takeoff"];
					$price += $flattedConnection["price"];

					continue;
				}

				$found = true;
				$path[] = $flattedConnection["takeoff"];
				$path[] = $flattedConnection["land"];
				$price += $flattedConnection["price"];
				break;
			}
		}

		if (!$found) {
			return null;
		}

		return [
			'path' => implode(",", $path),
			'price' => $price
		];
	}

	private function takeCheapest(&$routes)
	{
		usort($routes, function ($route1, $route2) {
			return $route1['price'] <=> $route2['price'];
		});

		return array_shift($routes);
	}

	public function findRoutes($takeoff, $land): array
	{
		$routes = $this->routeService->getAll();
		$tree = $this->buildRoutingTree($routes, $takeoff);

		$validRoutes = [];

		foreach ($tree as $branch) {
			if ($branch['takeoff'] === $takeoff && $branch['land'] === $land) {
				$validRoutes[] = [
					"path" => "$takeoff,$land",
					"price" => $branch['price']
				];
			}

			if (!isset($branch['connections'])) {
				continue;
			}

			$path = $this->findPath($branch, $land);

			if ($path) {
				$validRoutes[] = [
					"path" => $path["path"],
					"price" => $path["price"]
				];
			}
		}

		return [
			"cheapest_route" => $this->takeCheapest($validRoutes),
			"general_routes" => $validRoutes,
		];
	}
}

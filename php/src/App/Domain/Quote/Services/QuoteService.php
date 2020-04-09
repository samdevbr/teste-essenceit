<?php

namespace App\Domain\Quote\Services;

class QuoteService
{
	private function buildRoutingTree($routes, $from)
	{
		$tree = [];

		foreach ($routes as $route) {
			if ($route["from"] === $from) {
				$connections = $this->buildRoutingTree($routes, $route["to"]);

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
			'from' => $connection['from'],
			'to' => $connection['to'],
			'price' => $connection['price'],
		];

		if (isset($connection['connections'])) {
			foreach ($connection['connections'] as $conn) {
				$this->popConnections($conn, $out);
			}
		}
	}

	private function findPath(array $connections, $to)
	{
		$path = [
			$connections["from"]
		];
		$price = $connections["price"];
		$found = false;

		foreach ($connections['connections'] as $connection) {
			$flattedConnections = [];

			$this->popConnections($connection, $flattedConnections);

			foreach ($flattedConnections as $flattedConnection) {
				if ($flattedConnection['to'] !== $to) {
					$path[] = $flattedConnection["from"];
					$price += $flattedConnection["price"];

					continue;
				}

				$found = true;
				$path[] = $flattedConnection["from"];
				$path[] = $flattedConnection["to"];
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

	public function findRoutes($routes, $from, $to): array
	{
		$tree = $this->buildRoutingTree($routes, $from);

		$validRoutes = [];

		foreach ($tree as $branch) {
			if ($branch['from'] === $from && $branch['to'] === $to) {
				$validRoutes[] = [
					"path" => "$from,$to",
					"price" => $branch['price']
				];
			}

			if (!isset($branch['connections'])) {
				continue;
			}

			$path = $this->findPath($branch, $to);

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

<?php

$routes = [
	[
		"from" => "GRU",
		"to" => "BRC",
		"price" => 10
	],
	[
		"from" => "GRU",
		"to" => "SCL",
		"price" => 18
	],
	[
		"from" => "GRU",
		"to" => "ORL",
		"price" => 56
	],
	[
		"from" => "GRU",
		"to" => "CDG",
		"price" => 75
	],
	[
		"from" => "SCL",
		"to" => "ORL",
		"price" => 20
	],
	[
		"from" => "BRC",
		"to" => "SCL",
		"price" => 5
	],
	[
		"from" => "ORL",
		"to" => "CDG",
		"price" => 5
	],
	[
		"from" => "BBC",
		"to" => "BBD",
		"price" => 0
	]
];

function array_flatten($array)
{
	if (!is_array($array)) {
		return false;
	}

	$result = array();

	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$result = array_merge($result, array_flatten($value));
		} else {
			$result = array_merge($result, array($key => $value));
		}
	}

	return $result;
}

function buildRoutingTree($routes, $from)
{
	$tree = [];

	foreach ($routes as $route) {
		if ($route["from"] === $from) {
			$connections = buildRoutingTree($routes, $route["to"]);

			if ($connections) {
				$route['connections'] = $connections;
			}

			$tree[] = $route;
		}
	}

	return $tree;
}

function popConnections($connection, array &$out)
{
	$out[] = [
		'from' => $connection['from'],
		'to' => $connection['to'],
		'price' => $connection['price'],
	];

	if (isset($connection['connections'])) {
		foreach ($connection['connections'] as $conn) {
			popConnections($conn, $out);
		}
	}
}

function findRoutes($from, $to): array
{
	global $routes;

	$tree = buildRoutingTree($routes, $from);

	$validRoutes = [];

	function findPath(array $connections, $to)
	{
		$path = [
			$connections["from"]
		];
		$price = $connections["price"];
		$found = false;

		foreach ($connections['connections'] as $connection) {
			$flattedConnections = [];

			popConnections($connection, $flattedConnections);

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

		$path = findPath($branch, $to);

		if ($path) {
			$validRoutes[] = [
				"path" => $path["path"],
				"price" => $path["price"]
			];
		}
	}

	function takeCheapest(&$routes)
	{
		usort($routes, function ($route1, $route2) {
			return $route1['price'] <=> $route2['price'];
		});

		return array_shift($routes);
	}

	return [
		"cheapest_route" => takeCheapest($validRoutes),
		"general_routes" => $validRoutes,
	];
}

function printRoute($route) {
	echo "-------------------------------------" . PHP_EOL;
	echo "Rota.:\t{$route['path']}" . PHP_EOL;

	$price = number_format($route['price'], 2, ',', '.');
	echo "Valor:\tR\$$price" . PHP_EOL;
}

$avaiableRoutes = findRoutes("GRU", "CDG");

if (
	!$avaiableRoutes["cheapest_route"] &&
	empty($avaiableRoutes['general_routes'])
) {
	echo "Não foi possível encontrar uma rota para sua viagem." . PHP_EOL;
} else {

	echo "A rota mais barata é:" . PHP_EOL;
	printRoute($avaiableRoutes['cheapest_route']);

	if (count($avaiableRoutes) > 0) {
		echo PHP_EOL . "Outras rotas encontradas:" . PHP_EOL;
		foreach ($avaiableRoutes['general_routes'] as $route) {
			printRoute($route);
		}
	}
}

<?php

namespace App\Domain\Quote\Tests\Services;

use App\Infrastructure\Tests\TestCase;
use App\Domain\Quote\Services\QuoteService;
use App\Domain\Quote\Services\RouteService;

class QuoteServiceTest extends TestCase
{
	private $routes = [
		[
			"takeoff" => "GRU",
			"land" => "BRC",
			"price" => 10
		],
		[
			"takeoff" => "GRU",
			"land" => "SCL",
			"price" => 18
		],
		[
			"takeoff" => "GRU",
			"land" => "ORL",
			"price" => 56
		],
		[
			"takeoff" => "GRU",
			"land" => "CDG",
			"price" => 75
		],
		[
			"takeoff" => "SCL",
			"land" => "ORL",
			"price" => 20
		],
		[
			"takeoff" => "BRC",
			"land" => "SCL",
			"price" => 5
		],
		[
			"takeoff" => "ORL",
			"land" => "CDG",
			"price" => 5
		],
		[
			"takeoff" => "BBC",
			"land" => "BBD",
			"price" => 0
		]
	];

	/**
	 * @var QuoteService $quoteService
	 */
	private $quoteService;

	protected function setUp()
	{
		parent::setUp();

		$routeService = $this->createMock(RouteService::class);
		$routeService->method('getAll')->willReturn($this->routes);

		$this->quoteService = new QuoteService($routeService);
	}

	public function testCanFindCheapest()
	{
		$takeoff = "GRU";
		$land = "SCL";

		$cheapestRoute = [
			'path' => 'GRU,BRC,SCL',
			'price' => 15
		];

		$result = $this->quoteService->findRoutes($takeoff, $land);

		$this->assertEquals($cheapestRoute['path'], $result['cheapest_route']['path']);
		$this->assertEquals($cheapestRoute['price'], $result['cheapest_route']['price']);
		$this->assertNotEmpty($result['general_routes']);
	}

	public function testCanFindCheapestMultipleConnections()
	{
		$takeoff = "GRU";
		$land = "ORL";

		$cheapestRoute = [
			'path' => 'GRU,BRC,SCL,ORL',
			'price' => 35
		];

		$result = $this->quoteService->findRoutes($takeoff, $land);

		$this->assertEquals($cheapestRoute['path'], $result['cheapest_route']['path']);
		$this->assertEquals($cheapestRoute['price'], $result['cheapest_route']['price']);
		$this->assertNotEmpty($result['general_routes']);
	}

	public function testReturnEmptyWhenNoRouteFound()
	{
		$takeoff = "GRU";
		$land = "BBC";

		$result = $this->quoteService->findRoutes($takeoff, $land);

		$this->assertEmpty($result['cheapest_route']);
		$this->assertEmpty($result['general_routes']);
	}
}

<?php

namespace App\Domain\Quote\Tests\Services;

use App\Infrastructure\Tests\TestCase;
use App\Domain\Quote\Services\QuoteService;

class QuoteServiceTest extends TestCase
{
	private $routes = [
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
	/**
	 * @var QuoteService $quoteService
	 */
	private $quoteService;

	protected function setUp()
	{
		parent::setUp();

		$this->quoteService = new QuoteService;
	}

	public function testCanFindCheapest()
	{
		$from = "GRU";
		$to = "SCL";

		$cheapestRoute = [
			'path' => 'GRU,BRC,SCL',
			'price' => 15
		];

		$result = $this->quoteService->findRoutes($this->routes, $from, $to);

		$this->assertEquals($cheapestRoute['path'], $result['cheapest_route']['path']);
		$this->assertEquals($cheapestRoute['price'], $result['cheapest_route']['price']);
		$this->assertNotEmpty($result['general_routes']);
	}

	public function testCanFindCheapestMultipleConnections()
	{
		$from = "GRU";
		$to = "ORL";

		$cheapestRoute = [
			'path' => 'GRU,BRC,SCL,ORL',
			'price' => 35
		];

		$result = $this->quoteService->findRoutes($this->routes, $from, $to);

		$this->assertEquals($cheapestRoute['path'], $result['cheapest_route']['path']);
		$this->assertEquals($cheapestRoute['price'], $result['cheapest_route']['price']);
		$this->assertNotEmpty($result['general_routes']);
	}

	public function testReturnEmptyWhenNoRouteFound()
	{
		$from = "GRU";
		$to = "BBC";

		$result = $this->quoteService->findRoutes($this->routes, $from, $to);

		$this->assertEmpty($result['cheapest_route']);
		$this->assertEmpty($result['general_routes']);
	}
}

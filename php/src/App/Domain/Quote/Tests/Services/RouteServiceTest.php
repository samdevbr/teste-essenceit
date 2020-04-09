<?php

namespace App\Domain\Quote\Tests\Services;

use App\Domain\Quote\Repositories\RouteRepository;
use App\Infrastructure\Tests\TestCase;
use App\Domain\Quote\Services\RouteService;
use PHPUnit\Framework\MockObject\MockObject;

class RouteServiceTest extends TestCase
{
	/**
	 * @var MockObject $routeRepository
	 */
	private $routeRepository;
	/**
	 * @var RouteService $routeService
	 */
	private $routeService;

	protected function setUp()
	{
		parent::setUp();

		$this->routeRepository = $this->createMock(RouteRepository::class);
		$this->routeService = new RouteService($this->routeRepository);
	}

	public function testGetAll()
	{
		$routes = [
			[
				'id' => 1,
				'takeoff' => 'GRU',
				'land' => 'SCL',
				'price' => 5
			]
		];

		$this->routeRepository->expects($this->once())->method('all')->willReturn($routes);

		$this->assertEquals($routes, $this->routeService->getAll());
	}

	public function testCreate()
	{
		$this->routeRepository->expects($this->once())->method('create')->with("GRU", "SCL", 10);

		$this->routeService->create("GRU", "SCL", 10);
	}
}

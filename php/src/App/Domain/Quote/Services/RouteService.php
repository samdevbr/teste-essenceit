<?php
namespace App\Domain\Quote\Services;

use App\Domain\Quote\Repositories\RouteRepository;

class RouteService
{
	/**
	 * @var RouteRepository $routeRepository
	 */
	private $routeRepository;

	public function __construct(RouteRepository $routeRepository)
	{
		$this->routeRepository = $routeRepository;
	}

	public function getAll()
	{
		return $this->routeRepository->all();
	}

	public function create(string $takeoff, string $land, float $price)
	{
		$this->routeRepository->create($takeoff, $land, $price);
	}
}

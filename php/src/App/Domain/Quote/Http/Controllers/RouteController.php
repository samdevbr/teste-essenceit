<?php
namespace App\Domain\Quote\Http\Controllers;

use App\Infrastructure\Http\Controller;
use App\Domain\Quote\Services\RouteService;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Validation\Rules\Required;
use App\Infrastructure\Validation\Rules\IsNumeric;
use App\Domain\Quote\Repositories\RouteRepository;

class RouteController extends Controller
{
	/**
	 * @var RouteService $routeService
	 */
	private $routeService;

	public function __construct()
	{
		parent::__construct();

		$this->routeService = new RouteService(
			new RouteRepository(
				Connection::make()
			)
		);
	}

	public function all()
	{
		$this->json(
			$this->routeService->getAll()
		);
	}

	public function store()
	{
		$validated = $this->validate([
			'from' => [new Required],
			'to' => [new Required],
			'price' => [new Required, new IsNumeric],
		]);

		$this->routeService->create(
			$validated['from'],
			$validated['to'],
			$validated['price']
		);

		$this->json([]);
	}
}

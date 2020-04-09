<?php
namespace App\Domain\Quote\Http\Controllers;

use App\Domain\Quote\Repositories\RouteRepository;
use App\Domain\Quote\Services\QuoteService;
use App\Domain\Quote\Services\RouteService;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Http\Controller;

class QuoteController extends Controller
{
	/**
	 * @var QuoteService $quoteService
	 */
	private $quoteService;

	public function __construct()
	{
		$this->quoteService = new QuoteService(
			new RouteService(
				new RouteRepository(
					Connection::make()
				)
			)
		);
	}

	public function getQuote(string $from, string $to)
	{
		$this->json(
			$this->quoteService->findRoutes($from, $to)
		);
	}
}

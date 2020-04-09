<?php
namespace App\Domain\Quote\Http\Controllers;

use App\Infrastructure\Http\Controller;

class QuoteController extends Controller
{
	public function getQuote(string $from, string $to)
	{
		$this->json([[
			"from" => $from,
			"to" => $to
		]]);
	}
}

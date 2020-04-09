<?php
namespace App\Domain\Quote\Http\Controllers;

class QuoteController
{
	public function getQuote(string $from, string $to)
	{
		var_dump($from);
		var_dump($to);
	}
}

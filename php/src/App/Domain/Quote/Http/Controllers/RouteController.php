<?php
namespace App\Domain\Quote\Http\Controllers;

use App\Infrastructure\Http\Controller;
use App\Infrastructure\Http\Request;
use App\Infrastructure\Validation\Rules\IsNumeric;
use App\Infrastructure\Validation\Rules\Required;

class RouteController extends Controller
{
	public function store()
	{
		$validated = $this->validate([
			'from' => [new Required],
			'to' => [new Required],
			'price' => [new Required, new IsNumeric],
		]);
	}
}

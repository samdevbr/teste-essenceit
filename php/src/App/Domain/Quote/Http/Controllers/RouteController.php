<?php
namespace App\Domain\Quote\Http\Controllers;

use App\Infrastructure\Http\Controller;
use App\Infrastructure\Http\Request;

class RouteController extends Controller
{
	public function store()
	{
		$request = Request::capture();

		var_dump($request->input('data'));
	}
}

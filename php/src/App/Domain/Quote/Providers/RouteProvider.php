<?php

namespace App\Domain\Quote\Providers;

use App\Infrastructure\Contracts\IProvider;
use App\Infrastructure\Routing\Route;

class RouteProvider implements IProvider
{
	private $namespace = 'App\Domain\Quote\Http\Controllers\\';

	public function register()
	{
		Route::get('/quote/:from/:to', $this->namespace . 'QuoteController@getQuote');
		Route::post('/route', $this->namespace . 'RouteController@store');
	}
}

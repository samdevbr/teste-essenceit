<?php
namespace App\Infrastructure\Tests\Routing;

use App\Infrastructure\Http\Request;
use App\Infrastructure\Providers\RouteProvider;
use App\Infrastructure\Routing\Route;
use App\Infrastructure\Routing\Router;
use App\Infrastructure\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class RouterTest extends TestCase
{
	/**
	 * @var MockObject $routeProvider
	 */
	private $routeProvider;
	/**
	 * @var Router $router
	 */
	private $router;

	protected function setUp()
	{
		parent::setUp();

		$this->routeProvider = $this->createMock(RouteProvider::class);
		$this->router = new Router($this->routeProvider);
	}

	public function testRegistringRoutes()
	{
		$this->routeProvider->expects($this->once())->method('register');
		$this->router->mapRoutes();
	}

	public function testCanMatchRoutesFromRequest()
	{
		$validRequest = $this->createMock(Request::class);
		$validRequest->expects($this->once())->method('method')->willReturn('GET');
		$validRequest->expects($this->atLeast(2))->method('uri')->willReturn('/');

		$invalidRequest = $this->createMock(Request::class);
		$invalidRequest->expects($this->once())->method('method')->willReturn('GET');
		$invalidRequest->expects($this->once())->method('uri')->willReturn('/teste');

		$route = new Route("GET", "/", "Controller@Action");

		$this->router->addRoute($route);

		$this->assertSame($route, $this->router->tryRoute($validRequest));
		$this->assertNotSame($route, $this->router->tryRoute($invalidRequest));
	}
}

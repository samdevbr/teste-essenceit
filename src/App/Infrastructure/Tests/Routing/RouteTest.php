<?php
namespace App\Infrastructure\Tests\Routing;

use App\Infrastructure\Routing\Route;
use App\Infrastructure\Tests\TestCase;

class RouteTest extends TestCase
{
	public function testRouteClassResolving()
	{
		$route = new Route("GET", "/test", "Controller@Action");

		$this->assertEquals("Controller", $route->className);
		$this->assertEquals("Action", $route->classMethod);
	}

	public function testRouteParams()
	{
		$route = new Route("GET", "/test/:param1/:param2", "Controller@Action");

		$this->assertEquals(['param1', 'param2'], $route->params);
	}

	public function testRouteMethods()
	{
		$getRoute = new Route("GET", "/path", "Controller@Action");
		$postRoute = new Route("POST", "/path", "Controller@Action");

		$this->assertEquals("POST", $postRoute->method);
		$this->assertEquals("GET", $getRoute->method);
	}

	public function testRouteCanMatchUris()
	{
		$routeWithParam = new Route("GET", "/path/:param1", "Controller@Action");
		$routeWithoutParam = new Route("GET", "/path", "Controller@Action");

		$this->assertTrue($routeWithParam->matches("/path/123"));
		$this->assertTrue($routeWithParam->matches("/path/123?query=123"));
		$this->assertFalse($routeWithParam->matches("/path"));

		$this->assertTrue($routeWithoutParam->matches("/path"));
		$this->assertTrue($routeWithoutParam->matches("/path?query=123&another=123"));
		$this->assertFalse($routeWithoutParam->matches("/path/123"));
	}
}

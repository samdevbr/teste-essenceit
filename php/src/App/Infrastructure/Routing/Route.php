<?php

namespace App\Infrastructure\Routing;

class Route
{
	private $callback;

	public $method;
	public $uri;

	public $params = [];
	public $className;
	public $classMethod;

	public $uriRegex;

	private const PARAM_REGEX = '/\:([a-z0-9]{0,})/i';
	private const CALLBACK_REGEX = '/((.{1,})\@([a-z]{1,}))/i';

	public function __construct($method, $uri, $callback)
	{
		$this->method   = $method;
		$this->uri      = $uri;
		$this->uriRegex = $uri;
		$this->callback = $callback;

		$this->compileRoute();
	}

	private function compileParams()
	{
		preg_match_all(self::PARAM_REGEX, $this->uri, $matches);

		[, $paramNames] = $matches;

		$this->params = $paramNames;

		foreach ($this->params as $param) {
			$this->uriRegex = str_ireplace(':' . $param, '([a-z0-9]{1,})', $this->uriRegex);
		}

		$this->uriRegex = str_replace("/", "\/", $this->uriRegex);
		$this->uriRegex = "/^{$this->uriRegex}$/i";
	}

	private function compileCallback()
	{
		preg_match_all(self::CALLBACK_REGEX, $this->callback, $matches);

		[,, $className, $classMethod] = $matches;

		$this->className = $className[0];
		$this->classMethod = $classMethod[0];
	}

	private function compileRoute()
	{
		$this->compileParams();
		$this->compileCallback();
	}

	public function matches(string $uri)
	{
		[$uri,] = explode('?', $uri);

		return (bool)preg_match($this->uriRegex, $uri);
	}

	public function resolveClass()
	{
		return new $this->className;
	}

	public static function get(string $uri, $callback)
	{
		Router::make()->addRoute(new static('GET', $uri, $callback));
	}

	public static function post(string $uri, $callback)
	{
		Router::make()->addRoute(new static('POST', $uri, $callback));
	}
}

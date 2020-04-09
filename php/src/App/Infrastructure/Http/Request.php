<?php
namespace App\Infrastructure\Http;

class Request
{
	private $get;
	private $post;
	private $params = [];

	public function __construct()
	{
		$this->get  = &$_GET;
		$this->post = &$_POST;
	}

	public static function capture(): Request
	{
		return new static;
	}

	public function uri()
	{
		return $_SERVER['REQUEST_URI'];
	}

	public function method()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function query(string $key)
	{
		return $this->get[$key] ?? null;
	}

	public function input(string $key)
	{
		return $this->post[$key] ?? null;
	}

	public function addParam($key, $value)
	{
		$this->params[$key] = $value;
	}

	public function param($key, $default = null)
	{
		return $this->params[$key] ?? $default;
	}

	public function getParams()
	{
		return array_values($this->params);
	}
}

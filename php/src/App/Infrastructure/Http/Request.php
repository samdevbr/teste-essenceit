<?php
namespace App\Infrastructure\Http;

class Request
{
	private $get;
	private $post;

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
}

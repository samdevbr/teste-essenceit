<?php
namespace App\Infrastructure\Http;

class Response
{
	const HTTP_OK = 200;
	const HTTP_NOT_FOUND = 404;

	public static function json(int $code, array $body = [])
	{
		http_response_code($code);
		header("Content-type: application/json");

		echo json_encode($body);
	}
}
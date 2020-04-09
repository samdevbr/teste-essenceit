<?php
namespace App\Infrastructure\Http;

abstract class Controller
{
	protected function json(array $data, int $statusCode = Response::HTTP_OK)
	{
		Response::json($statusCode, $data);
	}
}

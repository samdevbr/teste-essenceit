<?php
namespace App\Infrastructure\Http;

use App\Infrastructure\Validation\Validator;

abstract class Controller
{
	protected $request;

	public function __construct()
	{
		$this->request = Request::capture();
	}

	protected function json(array $data, int $statusCode = Response::HTTP_OK)
	{
		Response::json($statusCode, $data);
	}

	protected function validate(array $rules)
	{
		$validator = Validator::make($this->request, $rules);

		if (!$validator->validate()) {
			$this->json($validator->errorBag, Response::HTTP_UNPROCESSABLE_ENTITY);
		} else {
			$validated = [];

			foreach ($rules as $attribute => $r) {
				$validated[$attribute] = $this->request->input($attribute);
			}

			return $validated;
		}
	}
}

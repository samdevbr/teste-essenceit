<?php
namespace App\Infrastructure\Validation\Rules;

use App\Infrastructure\Contracts\IValidationRule;

class Required implements IValidationRule
{
	public function message(): string
	{
		return "required";
	}

	public function passes($attribute, $value, \App\Infrastructure\Http\Request $request): bool
	{
		return $value !== null;
	}
}
<?php
namespace App\Infrastructure\Validation\Rules;

use App\Infrastructure\Contracts\IValidationRule;

class IsNumeric implements IValidationRule
{
	public function message(): string
	{
		return "has_to_be_numeric";
	}

	public function passes($attribute, $value, \App\Infrastructure\Http\Request $request): bool
	{
		return is_numeric($value);
	}
}

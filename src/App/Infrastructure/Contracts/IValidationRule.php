<?php
namespace App\Infrastructure\Contracts;

use App\Infrastructure\Http\Request;

interface IValidationRule
{
	function message(): string;
	function passes($attribute, $value, Request $request): bool;
}

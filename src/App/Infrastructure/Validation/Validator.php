<?php
namespace App\Infrastructure\Validation;

use App\Infrastructure\Contracts\IValidationRule;
use App\Infrastructure\Http\Request;

class Validator
{
	private $rules = [];
	private $request;

	public $errorBag = [];

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function addRule(string $attribute, IValidationRule $rule)
	{
		if (!$rule instanceof IValidationRule) {
			return;
		}

		if (!isset($this->rules[$attribute])) {
			$this->rules[$attribute] = [];
		}

		$this->rules[$attribute][] = $rule;
	}

	public function validate()
	{
		foreach ($this->rules as $attribute => $rules) {
			foreach ($rules as $rule) {
				if (!$rule->passes(
					$attribute,
					$this->request->input($attribute),
					$this->request
				)) {
					if (!isset($this->errorBag[$attribute])) {
						$this->errorBag[$attribute] = [];
					}

					$this->errorBag[$attribute][] = $rule->message();
				}
			}
		}

		return count($this->errorBag) === 0;
	}

	public static function make(Request $request, array $rules): Validator
	{
		$validator = new static($request);

		foreach ($rules as $attribute => $r) {
			if (is_array($r)) {
				foreach ($r as $rule) {
					$validator->addRule($attribute, $rule);
				}
			} else {
				$validator->addRule($attribute, $r);
			}
		}

		return $validator;
	}
}

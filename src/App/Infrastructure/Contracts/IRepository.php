<?php

namespace App\Infrastructure\Contracts;

interface IRepository
{
	function all();
	function create(...$args);
}

<?php
namespace App\Infrastructure\Database;

use PDO;

class Connection
{
	private static $instance = null;
	private $conn;

	public function __construct()
	{
		$this->conn = new PDO("mysql:host=127.0.0.1;dbname=essenceit", "root", "root");
	}

	public function exec($query, array $args = [])
	{
		$statement = $this->conn->prepare($query);
		$statement->execute($args);

		return $statement;
	}

	public static function make(): self
	{
		if (!self::$instance) {
			self::$instance = new static;
		}

		return self::$instance;
	}
}

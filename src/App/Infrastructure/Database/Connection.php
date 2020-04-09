<?php
namespace App\Infrastructure\Database;

use PDO;

class Connection
{
	private static $instance = null;
	private $conn;

	public function __construct()
	{
		$host = getenv('DB_HOST');
		$dbname = getenv('DB_NAME');
		$user = getenv('DB_USER');
		$pass = getenv('DB_PASS');

		$this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
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

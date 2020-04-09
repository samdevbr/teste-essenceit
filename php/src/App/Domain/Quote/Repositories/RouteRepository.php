<?php
namespace App\Domain\Quote\Repositories;

use App\Infrastructure\Contracts\IRepository;
use App\Infrastructure\Database\Connection;
use PDO;

class RouteRepository implements IRepository
{
	/**
	 * @var Connection $connection
	 */
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function all()
	{
		$query = $this->connection->exec("SELECT * FROM routes");
		$routes = $query->fetchAll(PDO::FETCH_ASSOC);

		return $routes;
	}

	public function create(...$args)
	{
		[$takeoff, $land, $price] = $args;

		$this->connection->exec("
			INSERT INTO routes (takeoff, land, price)
			VALUES (:takeoff, :land, :price)
		", [
			':takeoff' => $takeoff,
			':land' => $land,
			':price' => (float)$price
		]);
	}
}

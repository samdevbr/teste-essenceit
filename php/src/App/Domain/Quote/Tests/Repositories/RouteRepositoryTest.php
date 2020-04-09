<?php
namespace App\Domain\Quote\Repositories;

use PDO;
use PDOStatement;
use App\Infrastructure\Tests\TestCase;
use App\Infrastructure\Database\Connection;
use PHPUnit\Framework\MockObject\MockObject;

class RouteRepositoryTest extends TestCase
{
	/**
	 * @var MockObject $connection
	 */
	private $connection;

	/**
	 * @var RouteRepository
	 */
	private $routeRepository;

	protected function setUp()
	{
		$this->connection = $this->createMock(Connection::class);
		$this->routeRepository = new RouteRepository($this->connection);
	}

	public function testAll()
	{
		$statementMock = $this->createMock(PDOStatement::class);
		$this->connection->expects($this->once())->method('exec')->with("SELECT * FROM routes")->willReturn($statementMock);

		$statementMock->expects($this->once())->method('fetchAll')->with(PDO::FETCH_ASSOC);

		$this->routeRepository->all();
	}

	public function testCreate()
	{
		$query = "
			INSERT INTO routes (takeoff, land, price)
			VALUES (:takeoff, :land, :price)
		";

		$this->connection->expects($this->once())->method('exec')->with($query, [
			':takeoff' => "GRU",
			':land' => "SCL",
			':price' => 10
		]);

		$this->routeRepository->create("GRU", "SCL", 10);
	}
}

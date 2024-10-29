<?php
namespace App\Database;

use App\Database\Contracts\DBInterface;
use App\Database\Contracts\QueryBuilderInterface;
use PDO;

class DB implements DBInterface
{
	private PDO $connection;

	public function __construct(private string $dsn, private string $user, private string $password)
	{
		$this->connection = new PDO($dsn, $user, $password);
	}

	public static function make(string $dsn, string $user, string $password)
	{
		return new self($dsn, $user, $password);
	}

	public function query(): QueryBuilderInterface
	{
		return new QueryBuilder($this->connection);
	}

	public static function availableDrivers(): array
	{
		return PDO::getAvailableDrivers();
	}
}
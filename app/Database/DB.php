<?php
namespace App\Database;

use App\Database\Contracts\DBInterface;
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

	public function select(string $sql)
	{
		$statement = $this->connection->query($sql);
		return $statement->fetchAll();
	}

	public function exec(string $sql)
	{
		return $this->connection->exec($sql);
	}

	public function lastInsertId()
	{
		return $this->connection->lastInsertId();
	}

	public static function availableDrivers(): array
	{
		return PDO::getAvailableDrivers();
	}
}
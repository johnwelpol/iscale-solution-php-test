<?php
namespace App\Database;

use PDO;
use PDOStatement;
use App\Database\Contracts\QueryBuilderInterface;

class QueryBuilder implements QueryBuilderInterface {

    private string $query;

    private PDOStatement|false $statement;

    private array $bindParams = [];

    public function __construct(private PDO $connection)
    {
        
    }

    public function setQuery(string $query): self {
        $this->query = $query;
        return $this;
    }

    public function setBindParams(array $bindParams): self {
        $this->bindParams = $bindParams;
        return $this;
    }

    public function exec(): self {
        $this->statement = $this->connection->prepare($this->query);
		$this->statement->execute($this->bindParams);
        return $this;
    }

    public function get(): array {
        return $this->exec()
            ->statement
            ->fetchAll();
    }

    public function first(): mixed {
        return $this->exec()
            ->statement
            ->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertId(): string|bool {
        return $this->connection->lastInsertId();
    }
}
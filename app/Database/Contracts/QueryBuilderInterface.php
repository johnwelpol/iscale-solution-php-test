<?php
namespace App\Database\Contracts;

interface QueryBuilderInterface {
    public function setQuery(string $query): self;
    public function setBindParams(array $bindParams): self;
    public function get(): array;
    public function exec(): self;
    public function first(): mixed;
    public function lastInsertId(): string|bool;
}
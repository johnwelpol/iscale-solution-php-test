<?php
namespace App\Manager\Contracts;

use App\Database\Contracts\DBInterface;

interface DBManagerInterface {
    public function connection(string $connection): DBInterface;

    public function getDefaultConnection(): string;
}
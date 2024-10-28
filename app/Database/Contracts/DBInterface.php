<?php
namespace App\Database\Contracts;

interface DBInterface {
    public function select(string $sql);
    public function exec(string $sql);
    public function lastInsertId();
}
<?php
namespace App\Database\Contracts;

interface DBInterface {
    public function query(): QueryBuilderInterface;
}
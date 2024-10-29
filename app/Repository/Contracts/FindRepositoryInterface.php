<?php
namespace App\Repository\Contracts;

interface FindRepositoryInterface {
    public function find(string $id);
}
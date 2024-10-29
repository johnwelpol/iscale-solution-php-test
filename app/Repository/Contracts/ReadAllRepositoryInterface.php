<?php
namespace App\Repository\Contracts;

interface ReadAllRepositoryInterface {

    public function get(): array;
}
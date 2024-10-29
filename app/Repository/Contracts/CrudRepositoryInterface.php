<?php
namespace App\Repository\Contracts;

interface CrudRepositoryInterface extends CreateRepositoryInterface, ReadRepositoryInterface, UpdateRepositoryInterface, DeleteRepositoryInterface  {
}
<?php
namespace App\Factory\Contracts;

use App\Database\Contracts\DBInterface;

interface DBFactoryInterface {
    public function make(): DBInterface;
}
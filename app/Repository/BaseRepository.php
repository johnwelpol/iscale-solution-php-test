<?php
namespace App\Repository;

use App\Database\Contracts\DBInterface;

abstract class BaseRepository {
    protected DBInterface $db;

    public function __construct()
    {   
        $this->connection(app()->getDBManager()->getDefaultConnection());
    }
    
    public function connection(string $connection) {
        $this->db = app()->getDBManager()->connection($connection);
    }
}
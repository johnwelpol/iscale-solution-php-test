<?php
namespace App\Manager;

use Exception;
use App\Factory\DBFactory;
use App\Database\Contracts\DBInterface;
use App\Factory\Contracts\DBFactoryInterface;
use App\Manager\Contracts\DBManagerInterface;

class DBManager implements DBManagerInterface
{
	private static $instance = null;

    private static array $dbConfig = [];

    private array $factories = [];

    private array $connections = [];

    private array $resolved = [];

	public function __construct()
	{
        $this->init();
        self::$instance = $this;
	}

	public static function getInstance()
	{
		return self::$instance;
	}

    private function init() {
        $this->connections = array_keys(self::getDbConfig());
        foreach ($this->connections as $connection) {
            $this->factories[$connection] = DBFactory::new($connection);
        }
    }

    public function connection(string $connection): DBInterface {
        if (!in_array($connection, $this->connections)) {
            throw new Exception("DB Manager: Undefined connection given");
        }
        if (isset($this->resolved[$connection])) {
            return $this->resolved[$connection];
        }

        $this->resolved[$connection] = $this->resolveConnection($connection)->make();
        return $this->resolved[$connection];
    }

    private function resolveConnection(string $connection): DBFactoryInterface {
        if (!$this->factories[$connection] instanceof DBFactoryInterface) {
            throw new Exception("DB Manager: Invalid instance of DBFactory");
        }

        return $this->factories[$connection]->make();
    }

    public static function getDbConfig(): array {
        if (empty(self::$dbConfig)) {
            $dbConfig = [
                'default' => env('DB_CONNECTION', 'mysql'),
                
                'connections' => [
                    'mysql' => [
                        'driver' => 'mysql',
                        'host' => env('DB_HOST', '127.0.0.1'),
                        'port' => env('DB_PORT', '3306'),
                        'database' => env('DB_DATABASE', 'forge'),
                        'username' => env('DB_USERNAME', 'forge'),
                        'password' => env('DB_PASSWORD', ''),
                    ],
                ]
            ];
            if (empty($dbConfig)) {
                throw new Exception("No database configuration found.");
            } else {
                self::$dbConfig = $dbConfig;
            }
        }
        return self::$dbConfig;
    }
}
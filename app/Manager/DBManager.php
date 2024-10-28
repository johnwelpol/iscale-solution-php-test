<?php
namespace App\Manager;

use Exception;
use App\Factory\DBFactory;
use App\Database\Contracts\DBInterface;
use App\Factory\Contracts\DBFactoryInterface;
use App\Manager\Contracts\DBManagerInterface;

class DBManager implements DBManagerInterface
{
	private static DBManager|null $instance = null;

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
        if (is_null(self::$instance)) {
			self::$instance = new static;
		}
		return self::$instance;
	}

    private function init() {
        $this->connections = array_keys(self::getDbConfig()['connections']);
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

        $this->resolved[$connection] = $this->resolveConnection($connection);
        return $this->resolved[$connection];
    }

    private function resolveConnection(string $connection): DBInterface {
        if (!$this->factories[$connection] instanceof DBFactoryInterface) {
            throw new Exception("DB Manager: Invalid instance of DBFactory");
        }

        return $this->factories[$connection]->make();
    }

    public static function getDbConfig(): array {
        if (empty(self::$dbConfig)) {
            $dbConfig = ConfigManager::getInstance()->getAllConfigs()['db'];
            if (empty($dbConfig)) {
                throw new Exception("No database configuration found.");
            } else {
                self::$dbConfig = $dbConfig;
            }
        }
        return self::$dbConfig;
    }

    public function getDefaultConnection(): string {
        return self::getDbConfig()['default'] ?? 'mysql';
    }
}
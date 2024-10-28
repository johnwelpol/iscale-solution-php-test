<?php
namespace App\Factory;

use Exception;
use App\Manager\DB;
use App\Database\Contracts\DBInterface;
use App\Factory\Contracts\DBFactoryInterface;

class DBFactory implements DBFactoryInterface {

    private static array $dbConfig = [];
    private array $connectionConfig = [];

    public function __construct(private string $connection)
    {
        $this->initConnectionConfig();
    }

    public static function new(string $connection) {
        return new self($connection);
    }

    public function make(): DBInterface
    {
        $resolvedDSN = $this->resolveDSN(
            $this->connectionConfig['driver'], 
            $this->connectionConfig['database'], 
            $this->connectionConfig['host'], 
            $this->connectionConfig['port']
        );
        return  new DB($resolvedDSN, $this->connectionConfig['username'], $this->connectionConfig['password']);
    }

    private function resolveDSN(string $driver, string $dbName, string $host, string $port): string {
        if (!$this->isValidDriver($driver)) {
            throw new Exception("DB Factory error: Invalid driver selected");
        }

        return "$driver:dbname=$dbName;host=$host;port=$port";
    }

    private function isValidDriver(string $driver) {
        return in_array($driver, DB::availableDrivers());
    }

    private function initConnectionConfig() {
        if (empty(self::getDbConfig()[$this->connection])) {
            throw new Exception("DB Factory error: No database connection configuration found.");
        }
        $this->connectionConfig = self::getDbConfig()[$this->connection];
        $this->validateConfig($this->connectionConfig);
    }
    
    private function validateConfig(array $connectionConfig) {
        $requiredConfigs = [
            'driver',
            'host',
            'port',
            'database',
            'username',
        ];
        foreach ($requiredConfigs as $requiredConfig) {
            if (empty($connectionConfig[$requiredConfig])) {
                throw new Exception("DB Factory error: $requiredConfig is required. Kindly set the config");
            }
        }
    }

    public static function getDbConfig(): array {
        if (empty(self::$dbConfig)) {
            $dbConfig = app()->getConfig('db');
            if (empty($dbConfig)) {
                throw new Exception("No database configuration found.");
            } else {
                self::$dbConfig = $dbConfig;
            }
        }
        return self::$dbConfig;
    }
}
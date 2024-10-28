<?php
namespace App\Manager;

use Dotenv\Dotenv;
use App\Manager\Contracts\DBManagerInterface;
use App\Manager\Contracts\AppManagerInterface;
use App\Manager\Contracts\ConfigManagerInterface;

class AppManager implements AppManagerInterface {

    private AppManager|null $instance = null;

    private DBManagerInterface $dbManager;


    private ConfigManagerInterface $config;

    public function __construct()
    {
        
    }
    
	public static function getInstance()
	{
        if (is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    public function setConfigInstance(ConfigManagerInterface $config): self {
        $this->config = $config;
        return $this;
    }

    public function setDBManagerInstance(DBManagerInterface $dbManager): self {
        $this->dbManager = $dbManager;
        return $this;
    }

    public function boot(): self {
        $dotenv = Dotenv::createImmutable(BASE_DIR);
        $dotenv->load();
        return $this;
    }

    public function getConfigInstance(): ConfigManagerInterface {
        return $this->config;
    }

    public function getConfig(string $key): array {
        return $this->config->getConfig($key);
    }

    public function getDBManager(): DBManagerInterface {
        return $this->dbManager;
    }
}
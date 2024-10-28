<?php
namespace App\Manager;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Manager\Contracts\ConfigManagerInterface;

class ConfigManager implements ConfigManagerInterface {

    private static ConfigManager|null $instance = null;

    protected $configs = [];

    public function __construct(string $configFolder = 'config')
    {
        $this->loadConfigs($configFolder);
    }

    public static function getInstance()
	{
        if (is_null(self::$instance)) {
			self::$instance = new static;
		}
		return self::$instance;
	}

    protected function loadConfigs(string $folder): void
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
        
        foreach ($iterator as $file) {
            if ($file->isFile() && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $configName = basename($file, '.php');
                $this->configs[$configName] = require $file->getPathname();
            }
        }
    }

    public function getConfig(string $key): mixed
    {
        // TODO: Maybe add dot notation access?
        if (isset($this->configs[$key])) {
            return $this->configs[$key];
        }
        return null;
    }

    public function getAllConfigs(): array
    {
        return $this->configs;
    }
}
<?php
namespace App\Manager;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use App\Manager\Contracts\ConfigManagerInterface;

class ConfigManager implements ConfigManagerInterface {

    protected $configs = [];

    public function __construct(string $configFolder = 'config')
    {
        $this->loadConfigs($configFolder);
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
        foreach ($this->configs as $configName => $config) {
            if (isset($config[$key])) {
                return $config[$key];
            }
        }
        return null;
    }

    public function getAllConfigs(): array
    {
        return $this->configs;
    }
}
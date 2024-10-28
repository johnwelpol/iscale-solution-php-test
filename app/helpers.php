<?php

use App\Manager\AppManager;
use App\Manager\ConfigManager;

if (! function_exists('env')) {
    function env(string $name, mixed $default = null)
    {
        return $_ENV[$name] ?? $default;
    }
}

if (! function_exists('app')) {
    function app()
    {
        return AppManager::getInstance();
    }
}

if (! function_exists('config')) {
    function config(string $key, mixed $default = null)
    {
        return ConfigManager::getInstance()->getConfig($key) ?? $default;
    }
}
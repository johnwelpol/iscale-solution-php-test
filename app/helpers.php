<?php

use App\Manager\AppManager;

if (! function_exists('env')) {
    function env(string $name, $default = null)
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
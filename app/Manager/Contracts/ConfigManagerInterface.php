<?php
namespace App\Manager\Contracts;

interface ConfigManagerInterface {
    public function getConfig(string $key): mixed;
    public function getAllConfigs(): array;
}
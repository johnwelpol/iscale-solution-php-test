<?php 
namespace App\Manager\Contracts;


interface AppManagerInterface {
    public function setConfigInstance(ConfigManagerInterface $config): self;

    public function boot(): self;

    public function getConfigInstance(): ConfigManagerInterface;

    public function getConfig(string $key): array;

    public function setDBManagerInstance(DBManagerInterface $dbManager): self;

    public function getDBManager(): DBManagerInterface;
}
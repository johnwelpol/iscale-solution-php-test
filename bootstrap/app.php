<?php

use Dotenv\Dotenv;
use App\Manager\DBManager;
use App\Manager\AppManager;
use App\Manager\ConfigManager;
$dotenv = Dotenv::createImmutable(BASE_DIR);
$dotenv->load();
$config = ConfigManager::getInstance();
$dbManager = DBManager::getInstance();
return AppManager::getInstance()
    ->setConfigInstance($config)
    ->setDBManagerInstance($dbManager);
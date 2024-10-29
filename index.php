<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/helpers.php';

define('BASE_DIR', __DIR__);
use App\Manager\DBManager;
use App\Manager\AppManager;
use App\Manager\ConfigManager;
use App\Repository\NewsRepository;
use App\Repository\NewsCommentsRepository;

$config = ConfigManager::getInstance();
$dbManager = DBManager::getInstance();
$app = AppManager::getInstance()
	->setConfigInstance($config)
	->setDBManagerInstance($dbManager);

foreach (NewsRepository::getInstance()->get() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	$comments = NewsCommentsRepository::getInstance()->find($news->getId());
	foreach ($comments as $comment) {
		echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
	}
}
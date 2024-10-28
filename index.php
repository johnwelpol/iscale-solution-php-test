<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/helpers.php';

define('BASE_DIR', __DIR__);
use App\Manager\DBManager;
use App\Manager\AppManager;
use App\Manager\ConfigManager;
use App\Repository\NewsRepository;
use App\Repository\CommentRepository;

$config = ConfigManager::getInstance();
$dbManager = DBManager::getInstance();
$app = AppManager::getInstance()
	->setConfigInstance($config)
	->setDBManagerInstance($dbManager);

foreach (NewsRepository::getInstance()->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach (CommentRepository::getInstance()->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
		}
	}
}
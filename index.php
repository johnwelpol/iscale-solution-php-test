<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/helpers.php';

define('BASE_DIR', __DIR__);
use App\Manager\AppManager;
use App\Manager\ConfigManager;
use App\Manager\DBManager;
use App\Repository\NewsRepository;
use App\Repository\CommentRepository;

$config = new ConfigManager();
$dbManager = new DBManager();
$app = AppManager::getInstance();
$app->setConfigInstance($config)
	->setDBManagerInstance($dbManager)
	->boot();

foreach (NewsRepository::getInstance()->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach (CommentRepository::getInstance()->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
		}
	}
}
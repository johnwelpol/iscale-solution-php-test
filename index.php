<?php

require __DIR__ . '/vendor/autoload.php';

define('BASE_DIR', __DIR__);
use App\Repository\NewsRepository;
use App\Repository\NewsCommentsRepository;

$app = require(__DIR__ . '/bootstrap/app.php');

foreach (NewsRepository::getInstance()->get() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	$comments = NewsCommentsRepository::getInstance()->find($news->getId());
	foreach ($comments as $comment) {
		echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
	}
}
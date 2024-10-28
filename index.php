<?php

use App\Repository\NewsRepository;
use App\Repository\CommentRepository;

define('ROOT', __DIR__);
include 'autoloader.php';

foreach (NewsRepository::getInstance()->listNews() as $news) {
	echo("############ NEWS " . $news->getTitle() . " ############\n");
	echo($news->getBody() . "\n");
	foreach (CommentRepository::getInstance()->listComments() as $comment) {
		if ($comment->getNewsId() == $news->getId()) {
			echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
		}
	}
}

$commentRepository = CommentRepository::getInstance();
$c = $commentRepository->listComments();
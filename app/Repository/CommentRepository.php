<?php
namespace App\Repository;

use App\Models\Comment;
use App\Manager\DBManager;
use App\Repository\BaseRepository;

class CommentRepository extends BaseRepository
{
	private static $instance = null;

	private function __construct()
	{
	}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function listComments()
	{
		$rows = $this->db->select('SELECT * FROM `comment`');

		$comments = [];
		foreach($rows as $row) {
			$n = new Comment();
			$comments[] = $n->setId($row['id'])
			  ->setBody($row['body'])
			  ->setCreatedAt($row['created_at'])
			  ->setNewsId($row['news_id']);
		}

		return $comments;
	}

	public function addCommentForNews($body, $newsId)
	{
		$sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES('". $body . "','" . date('Y-m-d') . "','" . $newsId . "')";
		$this->db->exec($sql);
		return $this->db->lastInsertId($sql);
	}

	public function deleteComment($id)
	{
		$sql = "DELETE FROM `comment` WHERE `id`=" . $id;
		return $this->db->exec($sql);
	}
}
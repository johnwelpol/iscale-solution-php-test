<?php
namespace App\Repository;

use Exception;
use App\Models\Comment;
use App\Manager\DBManager;
use App\Repository\BaseRepository;
use App\Repository\Contracts\CreateRepositoryInterface;
use App\Repository\Contracts\DeleteRepositoryInterface;
use App\Repository\Contracts\ReadRepositoryInterface;

class CommentRepository extends BaseRepository implements ReadRepositoryInterface, CreateRepositoryInterface, DeleteRepositoryInterface
{
	private static $instance = null;

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function get(): array
	{
		$rows = $this->db
			->query()
			->setQuery('SELECT * FROM `comment`')
			->get();

		$comments = [];
		foreach($rows as $row) {
			$comments[] = Comment::fromArray($row);
		}

		return $comments;
	}

	public function create($comment)
	{
		$sql = "INSERT INTO `comment` (`body`, `news_id`, `created_at`) VALUES('?','?','?')";
		$query = $this->db
			->query()
			->setQuery($sql)
			->setBindParams([
				$comment->getBody(),
				$comment->getNewsId(),
				date('Y-m-d'),
			])
			->exec();
		$insertedID = $query->lastInsertId();
		if (is_null($insertedID)) {
			throw new Exception("Failed to create a news");
		}

		return $this->find($insertedID);
	}

	public function find(string $id)
	{
		$row = $this->db
			->query()
			->setQuery('SELECT * FROM `comment` WHERE id = ?')
			->setBindParams([$id])
			->first();

		return Comment::fromArray($row);
	}

	public function delete(string $id)
	{
		$sql = "DELETE FROM `comment` WHERE `id`= ?";
		return $this->db
			->query()
			->setQuery($sql)
			->setBindParams([$id])
			->exec();
	}
}
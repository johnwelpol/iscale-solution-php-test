<?php
namespace App\Repository;

use Exception;
use App\Models\News;
use App\Repository\Contracts\ReadRepositoryInterface;
use App\Repository\Contracts\CreateRepositoryInterface;
use App\Repository\Contracts\DeleteRepositoryInterface;

class NewsRepository extends BaseRepository implements ReadRepositoryInterface, CreateRepositoryInterface, DeleteRepositoryInterface
{
	private static $instance = null;

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	/**
	* list all news
	* @return array<News>
	*/
	public function get(): array
	{
		$rows = $this->db
			->query()
			->setQuery('SELECT * FROM `news`')
			->get();

		$news = [];
		foreach($rows as $row) {
			$news[] = News::fromArray($row);
		}

		return $news;
	}

	public function find(string $id)
	{
		$row = $this->db
			->query()
			->setQuery('SELECT * FROM `news` WHERE id = ?')
			->setBindParams([$id])
			->first();

		return News::fromArray($row);
	}

	/**
	* add a record in news table
	*/
	public function create($news)
	{
		$query = $this->db
			->query()
			->setQuery("INSERT INTO `news` (`title`, `body`, `created_at`) VALUES('?','?','?')")
			->setBindParams([
				$news->getTitle(), 
				$news->getBody(), 
				date('Y-m-d'),
			])
			->exec();
		$insertedID = $query->lastInsertId();
		if (is_null($insertedID)) {
			throw new Exception("Failed to create a news");
		}

		return $this->find($insertedID);
	}

	/**
	* deletes a news, and also linked comments
	*/
	public function delete(string $id): void
	{
		NewsCommentsRepository::getInstance()->delete($id);
		$query = $this->db
			->query()
			->setQuery("DELETE FROM `news` WHERE `id`= ?")
			->setBindParams([
				$id,
			]);
	}
}
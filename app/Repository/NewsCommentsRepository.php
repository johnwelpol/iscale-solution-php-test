<?php
namespace App\Repository;

use App\Models\Comment;
use App\Repository\Contracts\DeleteRepositoryInterface;
use App\Repository\Contracts\FindRepositoryInterface;

class NewsCommentsRepository extends BaseRepository implements DeleteRepositoryInterface, FindRepositoryInterface {

    private static $instance = null;

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}
    
    public function find(string $newsID): array
	{
		$rows = $this->db
			->query()
			->setQuery('SELECT * FROM `comment` WHERE `news_id`= ?')
            ->setBindParams([$newsID]) 
			->get();
		$comments = [];
		foreach($rows as $row) {
			$comments[] = Comment::fromArray($row);
		}

		return $comments;
	}

    public function delete(string $newsID): void {
        $sql = "DELETE FROM `comment` WHERE `news_id`= ?";
		$this->db
            ->query()
            ->setQuery($sql)
            ->setBindParams([$newsID])
            ->exec();
    }
}
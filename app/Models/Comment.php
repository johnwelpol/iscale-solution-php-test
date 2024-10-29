<?php
namespace App\Models;

use App\Models\Contracts\ModelInterface;

class Comment implements ModelInterface
{
	private int $id; 
	private string $body;
	private string $createdAt;
	private int $newsId;

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setBody($body)
	{
		$this->body = $body;

		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getNewsId()
	{
		return $this->newsId;
	}

	public function setNewsId($newsId)
	{
		$this->newsId = $newsId;

		return $this;
	}

	public static function fromArray(array $entity): Comment {
		$comment = new Comment();
		return $comment->setId($entity['id'])
			->setBody($entity['body'])
			->setCreatedAt($entity['created_at'])
			->setNewsId($entity['news_id']);
	}
}
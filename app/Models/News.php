<?php
namespace App\Models;

use App\Models\Contracts\ModelInterface;

class News implements ModelInterface
{
	private int $id;
	private string $title;
	private string $body;
	private string $createdAt;

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
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

	public static function fromArray(array $entity): News {
		$news = new News();
		$news->setId($entity['id'])
		  ->setTitle($entity['title'])
		  ->setBody($entity['body'])
		  ->setCreatedAt($entity['created_at']);
		return $news;
	}
}
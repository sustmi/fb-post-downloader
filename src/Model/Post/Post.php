<?php
declare(strict_types=1);

namespace App\Model\Post;

use DateTime;

class Post
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @param string $id
     * @param DateTime $createdAt
     */
    public function __construct(string $id, DateTime $createdAt)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
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
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $story;

    public function __construct(
        string $id,
        DateTime $createdAt,
        string $message = null,
        string $story = null
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->message = $message;
        $this->story = $story;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStory(): ?string
    {
        return $this->story;
    }
}
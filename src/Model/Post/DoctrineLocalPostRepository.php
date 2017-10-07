<?php
declare(strict_types=1);

namespace App\Model\Post;

class DoctrineLocalPostRepository implements LocalPostRepository
{
    /**
     * @var string
     */
    private $pageId;

    /**
     * @param string $pageId
     */
    public function __construct(string $pageId)
    {
        $this->pageId = $pageId;
    }

    public function getNewestPost(): ?Post
    {
        // TODO: Implement
        return null;
    }

    public function savePosts(array $posts): int
    {
        // TODO: Implement
        return count($posts);
    }
}
<?php

declare(strict_types=1);

namespace App\Tests;

use App\Model\Post\Post;
use App\Model\Post\PostSource;
use DateTime;

class TestPostSource implements PostSource
{
    /**
     * @var Post[]
     */
    private $sortedPosts;

    /**
     * @param Post[] $posts
     */
    public function __construct(array $posts)
    {
        usort($posts, function (Post $postA, Post $postB) {
            return $postA->getCreatedAt()->getTimestamp() - $postB->getCreatedAt()->getTimestamp();
        });

        $this->sortedPosts = $posts;
    }

    public function getPostsCreatedFrom(DateTime $createdFrom): array
    {
        $newPosts = [];

        foreach ($this->sortedPosts as $post) {
            if ($post->getCreatedAt() >= $createdFrom) {
                $newPosts[] = $post;
            }
        }

        return $newPosts;
    }

    public function getLastPosts(int $count): array
    {
        return array_slice($this->sortedPosts, -$count);
    }
}

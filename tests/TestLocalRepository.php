<?php
declare(strict_types=1);

namespace App\Tests;

use App\Model\Post\LocalPostRepository;
use App\Model\Post\Post;

class TestLocalRepository implements LocalPostRepository
{
    /**
     * @var Post[]
     */
    private $posts;

    /**
     * @param Post[] $posts
     */
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }

    public function getNewestPost(): ?Post
    {
        return count($this->posts) > 0 ? end($this->posts) : null;
    }

    /**
     * @param Post[] $posts
     * @return int
     */
    public function savePosts(array $posts): int
    {
        foreach ($posts as $post) {
            $this->posts[] = $post;
        }

        return count($posts);
    }

    /**
     * @return Post[]
     */
    public function getPosts(): array {
        return $this->posts;
    }
}
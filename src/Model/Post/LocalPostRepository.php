<?php
declare(strict_types=1);

namespace App\Model\Post;

/**
 * Adapter interface for local posts storage
 */
interface LocalPostRepository
{
    /**
     * Returns newest post or null if the storage is empty.
     *
     * @return Post|null
     */
    public function getNewestPost(): ?Post;

    /**
     * Saves the posts into local storage
     *
     * It is the responsibility of the storage not to store duplicate items.
     *
     * @param Post[] $posts
     * @return int Number of newly created posts
     */
    public function savePosts(array $posts): int;
}
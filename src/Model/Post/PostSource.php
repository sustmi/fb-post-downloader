<?php

declare(strict_types=1);

namespace App\Model\Post;

use DateTime;

/**
 * Adapter interface for retrieving posts from a remote web API
 */
interface PostSource
{
    /**
     * Gets posts created since the specified time (inclusive)
     *
     * @param DateTime $createdFrom Minimal creation time of the post (inclusive)
     * @return array Returns up to $limit of posts or an empty array in case
     *     there are no new posts.
     */
    public function getPostsCreatedFrom(DateTime $createdFrom): array;

    /**
     * Gets last $count posts
     *
     * @param int $count
     * @return Post[]
     */
    public function getLastPosts(int $count): array;
}

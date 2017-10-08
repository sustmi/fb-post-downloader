<?php
declare(strict_types=1);

namespace App\Model\Downloader;

use App\Model\Post\PostStorage;
use App\Model\Post\RemotePostRepository;

class PostDownloader
{
    /**
     * @param RemotePostRepository $remotePostRepository
     * @param PostStorage $postStorage
     * @param int $initialBatchSize Maximal number of posts to download
     *     when there is no last downloaded post to start from.
     * @return int Number of new posts
     */
    public function downloadNewPosts(
        RemotePostRepository $remotePostRepository,
        PostStorage $postStorage,
        int $initialBatchSize
    ): int {
        $lastPost = $postStorage->getNewestPost();

        if ($lastPost === null) {
            $posts = $remotePostRepository->getLastPosts($initialBatchSize);
        } else {
            $posts = $remotePostRepository->getPostsCreatedFrom($lastPost->getCreatedAt());
        }

        return $postStorage->savePosts($posts);
    }
}
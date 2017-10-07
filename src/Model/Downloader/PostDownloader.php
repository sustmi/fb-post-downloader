<?php
declare(strict_types=1);

namespace App\Model\Downloader;

use App\Model\Post\LocalPostRepository;
use App\Model\Post\RemotePostRepository;

class PostDownloader
{
    /**
     * @param RemotePostRepository $remotePostRepository
     * @param LocalPostRepository $localPostRepository
     * @param int $initialBatchSize Maximal number of posts to download
     *     when there is no last downloaded post to start from.
     * @return int Number of new posts
     */
    public function downloadNewPosts(
        RemotePostRepository $remotePostRepository,
        LocalPostRepository $localPostRepository,
        int $initialBatchSize
    ): int {
        $lastPost = $localPostRepository->getNewestPost();

        if ($lastPost === null) {
            $posts = $remotePostRepository->getLastPosts($initialBatchSize);
        } else {
            $posts = $remotePostRepository->getPostsCreatedFrom($lastPost->getCreatedAt());
        }

        return $localPostRepository->savePosts($posts);
    }
}
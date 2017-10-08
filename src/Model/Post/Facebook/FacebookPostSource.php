<?php
declare(strict_types=1);

namespace App\Model\Post\Facebook;

use App\Model\Post\Post;
use App\Model\Post\PostSource;
use DateTime;
use Facebook\Facebook;

class FacebookPostSource implements PostSource
{
    /**
     * @var string
     */
    private $pageId;

    /**
     * @var Facebook
     */
    private $facebook;

    public function __construct(
        string $pageId,
        Facebook $facebook
    ) {
        $this->pageId = $pageId;
        $this->facebook = $facebook;
    }

    public function getPostsCreatedFrom(DateTime $createdFrom): array
    {
        $endpoint = sprintf(
            '/%s/posts?limit=100&since=%d&until=%d',
            $this->pageId,
            $createdFrom->getTimestamp() - 1,
            (new DateTime())->getTimestamp()
        );

        $response = $this->facebook->get($endpoint);
        $edge = $response->getGraphEdge();

        $posts = [];
        do {
            foreach ($edge->asArray() as $item) {
                $posts[] = $this->createPostFromItemData($item);
            }

            $edge = $this->facebook->next($edge);
        } while ($edge !== null);

        return $posts;
    }

    public function getLastPosts(int $count): array
    {
        $endpoint = sprintf('/%s/posts?limit=100', $this->pageId);

        $response = $this->facebook->get($endpoint);
        $edge = $response->getGraphEdge();

        $posts = [];
        do {
            foreach ($edge->asArray() as $item) {
                $posts[] = $this->createPostFromItemData($item);

                if (count($posts) >= $count) {
                    return $posts;
                }
            }

            $edge = $this->facebook->next($edge);
        } while ($edge !== null);

        return $posts;
    }

    /**
     * @param array $item
     * @return Post
     */
    private function createPostFromItemData(array $item): Post
    {
        return new Post(
            $item['id'],
            $item['created_time'],
            $item['message'] ?? null,
            $item['story'] ?? null
        );
    }
}
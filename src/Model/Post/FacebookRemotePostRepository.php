<?php
declare(strict_types=1);

namespace App\Model\Post;

use DateTime;

class FacebookRemotePostRepository implements RemotePostRepository
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

    public function getPostsCreatedFrom(DateTime $createdFrom): array
    {
        // TODO: implement
        return [];
    }

    public function getLastPosts(int $count): array
    {
        // TODO: implement
        return [];
    }
}
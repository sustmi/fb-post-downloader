<?php
declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Page\Page;

class FacebookRemotePostRepositoryFactory
{
    public function createForPage(Page $page): FacebookRemotePostRepository
    {
        return new FacebookRemotePostRepository($page->getId());
    }
}
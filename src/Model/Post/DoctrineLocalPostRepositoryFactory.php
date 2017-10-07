<?php
declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Page\Page;

class DoctrineLocalPostRepositoryFactory
{
    public function createForPage(Page $page): DoctrineLocalPostRepository
    {
        return new DoctrineLocalPostRepository($page->getId());
    }
}
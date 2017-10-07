<?php
declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Page\Page;
use Doctrine\DBAL\Connection;

class DoctrineLocalPostRepositoryFactory
{
    /**
     * @var Connection
     */
    private $databaseConnection;

    public function __construct(Connection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function createForPage(Page $page): DoctrineLocalPostRepository
    {
        return new DoctrineLocalPostRepository(
            $page->getId(),
            $this->databaseConnection
        );
    }
}
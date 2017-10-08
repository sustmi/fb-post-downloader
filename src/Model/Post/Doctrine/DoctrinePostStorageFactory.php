<?php

declare(strict_types=1);

namespace App\Model\Post\Doctrine;

use App\Model\Page\Page;
use Doctrine\DBAL\Connection;

class DoctrinePostStorageFactory
{
    /**
     * @var Connection
     */
    private $databaseConnection;

    public function __construct(Connection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function createForPage(Page $page): DoctrinePostStorage
    {
        return new DoctrinePostStorage(
            $page->getId(),
            $this->databaseConnection
        );
    }
}

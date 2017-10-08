<?php
declare(strict_types=1);

namespace App\Model\Page;

use Doctrine\DBAL\Connection;

class PageRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Page[]
     */
    public function getAllPages(): array
    {
        $rows = $this->connection->fetchAll('SELECT id FROM pages');

        $pages = [];
        foreach ($rows as $row) {
            $pages[] = new Page($row['id']);
        }

        return $pages;
    }

    public function findById(string $pageId): ?Page
    {
        $row = $this->connection->fetchArray('SELECT id FROM pages WHERE id = :id', ['id' => $pageId]);

        if ($row === false) {
            return null;
        }

        return new Page($row);
    }

    public function addPage(string $pageId)
    {
        $this->connection->executeUpdate('INSERT INTO pages (id) VALUES (:id)', ['id' => $pageId]);
    }
}
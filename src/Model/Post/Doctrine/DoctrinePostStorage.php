<?php
declare(strict_types=1);

namespace App\Model\Post\Doctrine;

use App\Model\Post\PostStorage;
use App\Model\Post\Post;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

class DoctrinePostStorage implements PostStorage
{
    /**
     * @var string
     */
    private $pageId;

    /**
     * @var Connection
     */
    private $databaseConnection;

    public function __construct(
        string $pageId,
        Connection $databaseConnection
    ) {
        $this->pageId = $pageId;
        $this->databaseConnection = $databaseConnection;
    }

    public function getNewestPost(): ?Post
    {
        $row = $this->databaseConnection->fetchAssoc('
            SELECT id, created_at, message, story
            FROM posts
            WHERE page_id = :page_id
            ORDER BY created_at DESC
            LIMIT 1
        ', ['page_id' => $this->pageId]);

        if ($row === false) {
            return null;
        }

        return new Post(
            $row['id'],
            new DateTime($row['created_at']),
            $row['message'],
            $row['story']
        );
    }

    /**
     * @param Post[] $posts
     * @return int
     */
    public function savePosts(array $posts): int
    {
        $insertedPostsCount = 0;

        $stmt = $this->databaseConnection
            ->prepare('INSERT IGNORE INTO posts (id, page_id, created_at, message, story)
                VALUES (:id, :page_id, :created_at, :message, :story)');

        foreach ($posts as $post) {
            $stmt->bindValue('id', $post->getId());
            $stmt->bindValue('page_id', $this->pageId);
            $stmt->bindValue('created_at', $post->getCreatedAt(), Type::DATETIME);
            $stmt->bindValue('message', $post->getMessage());
            $stmt->bindValue('story', $post->getStory());
            $stmt->execute();
            $insertedPostsCount += $stmt->rowCount();
        }

        return $insertedPostsCount;
    }
}
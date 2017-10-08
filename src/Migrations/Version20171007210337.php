<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20171007210337 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $posts = $schema->createTable('posts');
        $posts->addColumn('id', 'string');
        $posts->addColumn('page_id', 'string');
        $posts->addColumn('created_at', 'datetime');
        $posts->addColumn('message', 'text');
        $posts->addColumn('story', 'text');
        $posts->setPrimaryKey(['id', 'page_id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('posts');
    }
}

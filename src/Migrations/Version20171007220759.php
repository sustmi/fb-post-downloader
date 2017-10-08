<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171007220759 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $pages = $schema->createTable('pages');
        $pages->addColumn('id', 'string');
        $pages->setPrimaryKey(['id']);

        $posts = $schema->getTable('posts');
        $posts->addForeignKeyConstraint('pages', ['page_id'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('pages');
    }
}

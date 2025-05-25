<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525124345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, description, size FROM product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(128) NOT NULL, description CLOB DEFAULT NULL, price INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO product (id, name, description, price) SELECT id, name, description, size FROM __temp__product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__product
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, description, price FROM product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(128) NOT NULL, description CLOB DEFAULT NULL, size INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO product (id, name, description, size) SELECT id, name, description, price FROM __temp__product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__product
        SQL);
    }
}

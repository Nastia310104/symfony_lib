<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211203070634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_authors (books_id INT NOT NULL, authors_id INT NOT NULL, INDEX IDX_877EACC27DD8AC20 (books_id), INDEX IDX_877EACC26DE2013A (authors_id), PRIMARY KEY(books_id, authors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC27DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC26DE2013A FOREIGN KEY (authors_id) REFERENCES authors (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE books_authors');
    }
}

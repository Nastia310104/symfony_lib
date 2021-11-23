<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123081033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE relations (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relations_books (relations_id INT NOT NULL, books_id INT NOT NULL, INDEX IDX_DF1A95701BFA63C8 (relations_id), INDEX IDX_DF1A95707DD8AC20 (books_id), PRIMARY KEY(relations_id, books_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relations_authors (relations_id INT NOT NULL, authors_id INT NOT NULL, INDEX IDX_B99A80231BFA63C8 (relations_id), INDEX IDX_B99A80236DE2013A (authors_id), PRIMARY KEY(relations_id, authors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE relations_books ADD CONSTRAINT FK_DF1A95701BFA63C8 FOREIGN KEY (relations_id) REFERENCES relations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE relations_books ADD CONSTRAINT FK_DF1A95707DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE relations_authors ADD CONSTRAINT FK_B99A80231BFA63C8 FOREIGN KEY (relations_id) REFERENCES relations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE relations_authors ADD CONSTRAINT FK_B99A80236DE2013A FOREIGN KEY (authors_id) REFERENCES authors (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE books_authors');
        $this->addSql('ALTER TABLE authors DROP book_name, CHANGE author_id quantity INT NOT NULL');
        $this->addSql('ALTER TABLE books DROP book_id, CHANGE b_name title VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE relations_books DROP FOREIGN KEY FK_DF1A95701BFA63C8');
        $this->addSql('ALTER TABLE relations_authors DROP FOREIGN KEY FK_B99A80231BFA63C8');
        $this->addSql('CREATE TABLE books_authors (books_id INT NOT NULL, authors_id INT NOT NULL, INDEX IDX_877EACC26DE2013A (authors_id), INDEX IDX_877EACC27DD8AC20 (books_id), PRIMARY KEY(books_id, authors_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC26DE2013A FOREIGN KEY (authors_id) REFERENCES authors (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE books_authors ADD CONSTRAINT FK_877EACC27DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE relations');
        $this->addSql('DROP TABLE relations_books');
        $this->addSql('DROP TABLE relations_authors');
        $this->addSql('ALTER TABLE authors ADD book_name LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE quantity author_id INT NOT NULL');
        $this->addSql('ALTER TABLE books ADD book_id INT NOT NULL, CHANGE title b_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

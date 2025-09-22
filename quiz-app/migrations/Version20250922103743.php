<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922103743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_quiz (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, quiz_version_id INT NOT NULL, client_version VARCHAR(20) NOT NULL, INDEX IDX_758E39F019EB6921 (client_id), INDEX IDX_758E39F02D30039 (quiz_version_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, quiz_version_id INT NOT NULL, text LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, options JSON DEFAULT NULL, INDEX IDX_B6F7494E2D30039 (quiz_version_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_version (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, version VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AD467E63853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_quiz ADD CONSTRAINT FK_758E39F019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_quiz ADD CONSTRAINT FK_758E39F02D30039 FOREIGN KEY (quiz_version_id) REFERENCES quiz_version (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2D30039 FOREIGN KEY (quiz_version_id) REFERENCES quiz_version (id)');
        $this->addSql('ALTER TABLE quiz_version ADD CONSTRAINT FK_AD467E63853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_quiz DROP FOREIGN KEY FK_758E39F019EB6921');
        $this->addSql('ALTER TABLE client_quiz DROP FOREIGN KEY FK_758E39F02D30039');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2D30039');
        $this->addSql('ALTER TABLE quiz_version DROP FOREIGN KEY FK_AD467E63853CD175');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_quiz');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_version');
    }
}

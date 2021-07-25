<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210724232330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD codes_id INT NOT NULL, ADD parent_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD nickname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C6485E21C FOREIGN KEY (codes_id) REFERENCES code (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C727ACA70 FOREIGN KEY (parent_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_9474526C6485E21C ON comment (codes_id)');
        $this->addSql('CREATE INDEX IDX_9474526C727ACA70 ON comment (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C6485E21C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C727ACA70');
        $this->addSql('DROP INDEX IDX_9474526C6485E21C ON comment');
        $this->addSql('DROP INDEX IDX_9474526C727ACA70 ON comment');
        $this->addSql('ALTER TABLE comment DROP codes_id, DROP parent_id, DROP active, DROP email, DROP nickname');
    }
}

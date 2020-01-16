<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191230140753 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE military_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE soldier ADD military_unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE soldier ADD CONSTRAINT FK_B04F2D0236CF85F4 FOREIGN KEY (military_unit_id) REFERENCES military_unit (id)');
        $this->addSql('CREATE INDEX IDX_B04F2D0236CF85F4 ON soldier (military_unit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE soldier DROP FOREIGN KEY FK_B04F2D0236CF85F4');
        $this->addSql('DROP TABLE military_unit');
        $this->addSql('DROP INDEX IDX_B04F2D0236CF85F4 ON soldier');
        $this->addSql('ALTER TABLE soldier DROP military_unit_id');
    }
}

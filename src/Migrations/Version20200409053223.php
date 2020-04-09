<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409053223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sales (id INT AUTO_INCREMENT NOT NULL, item_id_id INT DEFAULT NULL, order_qty INT NOT NULL, batch_sequence INT NOT NULL, cost_price NUMERIC(10, 2) NOT NULL, sell_price NUMERIC(10, 2) NOT NULL, date TIMESTAMP NOT NULL, INDEX IDX_6B81704455E38587 (item_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, quantity INT NOT NULL, cost_price NUMERIC(10, 2) NOT NULL, batch_sequence INT NOT NULL, purchase_date TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B81704455E38587 FOREIGN KEY (item_id_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B81704455E38587');
        $this->addSql('DROP TABLE sales');
        $this->addSql('DROP TABLE product');
    }
}

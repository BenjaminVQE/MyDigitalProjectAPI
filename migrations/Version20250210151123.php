<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210151123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, address_type VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, postal_code INT NOT NULL, number_street INT NOT NULL, INDEX IDX_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_4E004AACA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carts_article (carts_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_8C28D1C7BCB5C6F5 (carts_id), INDEX IDX_8C28D1C77294869C (article_id), PRIMARY KEY(carts_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_F52993981AD5CDBF (cart_id), INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE carts ADD CONSTRAINT FK_4E004AACA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE carts_article ADD CONSTRAINT FK_8C28D1C7BCB5C6F5 FOREIGN KEY (carts_id) REFERENCES carts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carts_article ADD CONSTRAINT FK_8C28D1C77294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993981AD5CDBF FOREIGN KEY (cart_id) REFERENCES carts (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article DROP price, CHANGE name name VARCHAR(255) NOT NULL, CHANGE width width NUMERIC(10, 2) NOT NULL, CHANGE height height NUMERIC(10, 2) NOT NULL, CHANGE matter matter VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395');
        $this->addSql('ALTER TABLE carts DROP FOREIGN KEY FK_4E004AACA76ED395');
        $this->addSql('ALTER TABLE carts_article DROP FOREIGN KEY FK_8C28D1C7BCB5C6F5');
        $this->addSql('ALTER TABLE carts_article DROP FOREIGN KEY FK_8C28D1C77294869C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993981AD5CDBF');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE carts');
        $this->addSql('DROP TABLE carts_article');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE article ADD price NUMERIC(3, 2) NOT NULL, CHANGE name name VARCHAR(75) NOT NULL, CHANGE width width INT NOT NULL, CHANGE height height INT NOT NULL, CHANGE matter matter VARCHAR(50) NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302122052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plat_ingrediant DROP FOREIGN KEY FK_E7E4EF27D73DB560');
        $this->addSql('ALTER TABLE plat_ingrediant DROP FOREIGN KEY FK_E7E4EF278AEA29A');
        $this->addSql('ALTER TABLE plat_menu DROP FOREIGN KEY FK_CA9ED79CCCD7E912');
        $this->addSql('ALTER TABLE plat_menu DROP FOREIGN KEY FK_CA9ED79CD73DB560');
        $this->addSql('DROP TABLE plat_ingrediant');
        $this->addSql('DROP TABLE plat_menu');
        $this->addSql('ALTER TABLE article CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE commande ADD poste_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD plats_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93AA14E1C8 FOREIGN KEY (plats_id) REFERENCES plat (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93AA14E1C8 ON menu (plats_id)');
        $this->addSql('ALTER TABLE plat ADD ingrediants_id INT NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207F7A369DD FOREIGN KEY (ingrediants_id) REFERENCES ingrediant (id)');
        $this->addSql('CREATE INDEX IDX_2038A207F7A369DD ON plat (ingrediants_id)');
        $this->addSql('ALTER TABLE user CHANGE zone zone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plat_ingrediant (plat_id INT NOT NULL, ingrediant_id INT NOT NULL, INDEX IDX_E7E4EF278AEA29A (ingrediant_id), INDEX IDX_E7E4EF27D73DB560 (plat_id), PRIMARY KEY(plat_id, ingrediant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plat_menu (plat_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_CA9ED79CCCD7E912 (menu_id), INDEX IDX_CA9ED79CD73DB560 (plat_id), PRIMARY KEY(plat_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE plat_ingrediant ADD CONSTRAINT FK_E7E4EF27D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_ingrediant ADD CONSTRAINT FK_E7E4EF278AEA29A FOREIGN KEY (ingrediant_id) REFERENCES ingrediant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_menu ADD CONSTRAINT FK_CA9ED79CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_menu ADD CONSTRAINT FK_CA9ED79CD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE commande DROP poste_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93AA14E1C8');
        $this->addSql('DROP INDEX IDX_7D053A93AA14E1C8 ON menu');
        $this->addSql('ALTER TABLE menu DROP plats_id');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207F7A369DD');
        $this->addSql('DROP INDEX IDX_2038A207F7A369DD ON plat');
        $this->addSql('ALTER TABLE plat DROP ingrediants_id');
        $this->addSql('ALTER TABLE `user` CHANGE zone zone VARCHAR(255) DEFAULT NULL');
    }
}

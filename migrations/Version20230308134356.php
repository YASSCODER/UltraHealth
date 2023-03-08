<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308134356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FB88E14F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F');
        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAFFB88E14F');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93FB88E14F');
        $this->addSql('ALTER TABLE passe DROP FOREIGN KEY FK_D317EE5FFB88E14F');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EFB88E14F');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_49CA4E7D7294869C (article_id), INDEX IDX_49CA4E7DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, cin VARCHAR(8) NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, date_naissance DATE NOT NULL, zonde VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(30) NOT NULL, role VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE plat_ingrediant DROP FOREIGN KEY FK_E7E4EF278AEA29A');
        $this->addSql('ALTER TABLE plat_ingrediant DROP FOREIGN KEY FK_E7E4EF27D73DB560');
        $this->addSql('ALTER TABLE plat_menu DROP FOREIGN KEY FK_CA9ED79CCCD7E912');
        $this->addSql('ALTER TABLE plat_menu DROP FOREIGN KEY FK_CA9ED79CD73DB560');
        $this->addSql('DROP TABLE plat_ingrediant');
        $this->addSql('DROP TABLE plat_menu');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX IDX_23A0E66FB88E14F ON article');
        $this->addSql('ALTER TABLE article ADD image VARCHAR(255) DEFAULT NULL, CHANGE utilisateur_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('DROP INDEX IDX_6EEAA67DFB88E14F ON commande');
        $this->addSql('ALTER TABLE commande ADD poste_id INT NOT NULL, CHANGE utilisateur_id commande_owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA81C7963 FOREIGN KEY (commande_owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA81C7963 ON commande (commande_owner_id)');
        $this->addSql('DROP INDEX IDX_93BF4CAFFB88E14F ON commantaire');
        $this->addSql('ALTER TABLE commantaire ADD titre VARCHAR(255) NOT NULL, CHANGE utilisateur_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAFF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_93BF4CAFF675F31B ON commantaire (author_id)');
        $this->addSql('DROP INDEX IDX_7D053A93FB88E14F ON menu');
        $this->addSql('ALTER TABLE menu ADD user_owner_id INT NOT NULL, CHANGE utilisateur_id plats_id INT NOT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93AA14E1C8 FOREIGN KEY (plats_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A939EB185F9 FOREIGN KEY (user_owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93AA14E1C8 ON menu (plats_id)');
        $this->addSql('CREATE INDEX IDX_7D053A939EB185F9 ON menu (user_owner_id)');
        $this->addSql('DROP INDEX IDX_D317EE5FFB88E14F ON passe');
        $this->addSql('ALTER TABLE passe CHANGE utilisateur_id passe_owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE passe ADD CONSTRAINT FK_D317EE5F5D9E51AC FOREIGN KEY (passe_owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_D317EE5F5D9E51AC ON passe (passe_owner_id)');
        $this->addSql('ALTER TABLE plat ADD ingrediants_id INT NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207F7A369DD FOREIGN KEY (ingrediants_id) REFERENCES ingrediant (id)');
        $this->addSql('CREATE INDEX IDX_2038A207F7A369DD ON plat (ingrediants_id)');
        $this->addSql('DROP INDEX IDX_B6F7494EFB88E14F ON question');
        $this->addSql('ALTER TABLE question CHANGE utilisateur_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EF675F31B ON question (author_id)');
        $this->addSql('ALTER TABLE reponse ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7F675F31B ON reponse (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA81C7963');
        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAFF675F31B');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A939EB185F9');
        $this->addSql('ALTER TABLE passe DROP FOREIGN KEY FK_D317EE5F5D9E51AC');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EF675F31B');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7F675F31B');
        $this->addSql('CREATE TABLE plat_ingrediant (plat_id INT NOT NULL, ingrediant_id INT NOT NULL, INDEX IDX_E7E4EF27D73DB560 (plat_id), INDEX IDX_E7E4EF278AEA29A (ingrediant_id), PRIMARY KEY(plat_id, ingrediant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plat_menu (plat_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_CA9ED79CD73DB560 (plat_id), INDEX IDX_CA9ED79CCCD7E912 (menu_id), PRIMARY KEY(plat_id, menu_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cin VARCHAR(8) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, zone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE plat_ingrediant ADD CONSTRAINT FK_E7E4EF278AEA29A FOREIGN KEY (ingrediant_id) REFERENCES ingrediant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_ingrediant ADD CONSTRAINT FK_E7E4EF27D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_menu ADD CONSTRAINT FK_CA9ED79CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_menu ADD CONSTRAINT FK_CA9ED79CD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D7294869C');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B ON article');
        $this->addSql('ALTER TABLE article DROP image, CHANGE author_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66FB88E14F ON article (utilisateur_id)');
        $this->addSql('DROP INDEX IDX_6EEAA67DA81C7963 ON commande');
        $this->addSql('ALTER TABLE commande ADD utilisateur_id INT NOT NULL, DROP commande_owner_id, DROP poste_id');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DFB88E14F ON commande (utilisateur_id)');
        $this->addSql('DROP INDEX IDX_93BF4CAFF675F31B ON commantaire');
        $this->addSql('ALTER TABLE commantaire DROP titre, CHANGE author_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAFFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_93BF4CAFFB88E14F ON commantaire (utilisateur_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93AA14E1C8');
        $this->addSql('DROP INDEX IDX_7D053A93AA14E1C8 ON menu');
        $this->addSql('DROP INDEX IDX_7D053A939EB185F9 ON menu');
        $this->addSql('ALTER TABLE menu ADD utilisateur_id INT NOT NULL, DROP plats_id, DROP user_owner_id');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93FB88E14F ON menu (utilisateur_id)');
        $this->addSql('DROP INDEX IDX_D317EE5F5D9E51AC ON passe');
        $this->addSql('ALTER TABLE passe CHANGE passe_owner_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE passe ADD CONSTRAINT FK_D317EE5FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_D317EE5FFB88E14F ON passe (utilisateur_id)');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207F7A369DD');
        $this->addSql('DROP INDEX IDX_2038A207F7A369DD ON plat');
        $this->addSql('ALTER TABLE plat DROP ingrediants_id');
        $this->addSql('DROP INDEX IDX_B6F7494EF675F31B ON question');
        $this->addSql('ALTER TABLE question CHANGE author_id utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EFB88E14F ON question (utilisateur_id)');
        $this->addSql('DROP INDEX IDX_5FB6DEC7F675F31B ON reponse');
        $this->addSql('ALTER TABLE reponse DROP author_id');
    }
}

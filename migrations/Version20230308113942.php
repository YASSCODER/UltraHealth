<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308113942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_49CA4E7D7294869C (article_id), INDEX IDX_49CA4E7DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande ADD poste_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA81C7963 FOREIGN KEY (commande_owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commande_product ADD CONSTRAINT FK_25F1760D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_product ADD CONSTRAINT FK_25F1760D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAFA0905086 FOREIGN KEY (poste_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commantaire ADD CONSTRAINT FK_93BF4CAFF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A691EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('ALTER TABLE evennement ADD CONSTRAINT FK_5C15C77412469DE2 FOREIGN KEY (category_id) REFERENCES event_category (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93AA14E1C8 FOREIGN KEY (plats_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A939EB185F9 FOREIGN KEY (user_owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE passe ADD CONSTRAINT FK_D317EE5FDCDFA082 FOREIGN KEY (evennement_id) REFERENCES evennement (id)');
        $this->addSql('ALTER TABLE passe ADD CONSTRAINT FK_D317EE5F5D9E51AC FOREIGN KEY (passe_owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207F7A369DD FOREIGN KEY (ingrediants_id) REFERENCES ingrediant (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES product_category (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED54FAE5E FOREIGN KEY (titre_id) REFERENCES sujet (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D7294869C');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('DROP TABLE likes');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE article CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA81C7963');
        $this->addSql('ALTER TABLE commande DROP poste_id');
        $this->addSql('ALTER TABLE commande_product DROP FOREIGN KEY FK_25F1760D82EA2E54');
        $this->addSql('ALTER TABLE commande_product DROP FOREIGN KEY FK_25F1760D4584665A');
        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAFA0905086');
        $this->addSql('ALTER TABLE commantaire DROP FOREIGN KEY FK_93BF4CAFF675F31B');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A691EF7EAA');
        $this->addSql('ALTER TABLE evennement DROP FOREIGN KEY FK_5C15C77412469DE2');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93AA14E1C8');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A939EB185F9');
        $this->addSql('ALTER TABLE passe DROP FOREIGN KEY FK_D317EE5FDCDFA082');
        $this->addSql('ALTER TABLE passe DROP FOREIGN KEY FK_D317EE5F5D9E51AC');
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207F7A369DD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ED54FAE5E');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EF675F31B');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71E27F6BF');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7F675F31B');
    }
}

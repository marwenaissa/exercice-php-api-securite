<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009094218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet_user (projet_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FA413966C18272 (projet_id), INDEX IDX_FA413966A76ED395 (user_id), PRIMARY KEY(projet_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_user ADD CONSTRAINT FK_FA413966C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_user ADD CONSTRAINT FK_FA413966A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794A76ED395');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794C18272');
        $this->addSql('DROP TABLE user_projet');
        $this->addSql('ALTER TABLE societe CHANGE nnumero_siret numero_siret VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_societe DROP FOREIGN KEY FK_416823B7A76ED395');
        $this->addSql('ALTER TABLE user_societe DROP FOREIGN KEY FK_416823B7FCF77503');
        $this->addSql('DROP INDEX IDX_416823B7A76ED395 ON user_societe');
        $this->addSql('DROP INDEX IDX_416823B7FCF77503 ON user_societe');
        $this->addSql('ALTER TABLE user_societe ADD id INT AUTO_INCREMENT NOT NULL, ADD id_user_id INT DEFAULT NULL, ADD id_societe_id INT DEFAULT NULL, ADD id_role_id INT DEFAULT NULL, DROP user_id, DROP societe_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user_societe ADD CONSTRAINT FK_416823B779F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_societe ADD CONSTRAINT FK_416823B7597DF5D4 FOREIGN KEY (id_societe_id) REFERENCES societe (id)');
        $this->addSql('ALTER TABLE user_societe ADD CONSTRAINT FK_416823B789E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_416823B779F37AE5 ON user_societe (id_user_id)');
        $this->addSql('CREATE INDEX IDX_416823B7597DF5D4 ON user_societe (id_societe_id)');
        $this->addSql('CREATE INDEX IDX_416823B789E8BDC ON user_societe (id_role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_societe DROP FOREIGN KEY FK_416823B789E8BDC');
        $this->addSql('CREATE TABLE user_projet (user_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_35478794A76ED395 (user_id), INDEX IDX_35478794C18272 (projet_id), PRIMARY KEY(user_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_projet ADD CONSTRAINT FK_35478794A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_projet ADD CONSTRAINT FK_35478794C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_user DROP FOREIGN KEY FK_FA413966C18272');
        $this->addSql('ALTER TABLE projet_user DROP FOREIGN KEY FK_FA413966A76ED395');
        $this->addSql('DROP TABLE projet_user');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE user_societe MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user_societe DROP FOREIGN KEY FK_416823B779F37AE5');
        $this->addSql('ALTER TABLE user_societe DROP FOREIGN KEY FK_416823B7597DF5D4');
        $this->addSql('DROP INDEX IDX_416823B779F37AE5 ON user_societe');
        $this->addSql('DROP INDEX IDX_416823B7597DF5D4 ON user_societe');
        $this->addSql('DROP INDEX IDX_416823B789E8BDC ON user_societe');
        $this->addSql('DROP INDEX `PRIMARY` ON user_societe');
        $this->addSql('ALTER TABLE user_societe ADD user_id INT NOT NULL, ADD societe_id INT NOT NULL, DROP id, DROP id_user_id, DROP id_societe_id, DROP id_role_id');
        $this->addSql('ALTER TABLE user_societe ADD CONSTRAINT FK_416823B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_societe ADD CONSTRAINT FK_416823B7FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_416823B7A76ED395 ON user_societe (user_id)');
        $this->addSql('CREATE INDEX IDX_416823B7FCF77503 ON user_societe (societe_id)');
        $this->addSql('ALTER TABLE user_societe ADD PRIMARY KEY (user_id, societe_id)');
        $this->addSql('ALTER TABLE societe CHANGE numero_siret nnumero_siret VARCHAR(255) NOT NULL');
    }
}

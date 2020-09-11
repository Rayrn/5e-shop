<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911105859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE store (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, item_type VARCHAR(255) NOT NULL, item_level VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, weight INT NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1F1B251E5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon (id INT NOT NULL, weapon_type VARCHAR(255) NOT NULL, damage_dice_type INT NOT NULL, damage_dice_number INT NOT NULL, damage_type VARCHAR(255) NOT NULL, damage_bonus INT DEFAULT NULL, ammuntion TINYINT(1) NOT NULL, finesse TINYINT(1) NOT NULL, heavy TINYINT(1) NOT NULL, light TINYINT(1) NOT NULL, loading TINYINT(1) NOT NULL, reach TINYINT(1) NOT NULL, two_handed TINYINT(1) NOT NULL, thrown TINYINT(1) NOT NULL, short_range INT DEFAULT NULL, long_range INT DEFAULT NULL, versatile TINYINT(1) NOT NULL, versatile_damage_dice INT DEFAULT NULL, versatile_damage_dice_number INT DEFAULT NULL, special TINYINT(1) NOT NULL, special_text VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store_items (item_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_9D20BF54126F525E (item_id), INDEX IDX_9D20BF544D16C4DD (shop_id), PRIMARY KEY(item_id, shop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE armour (id INT NOT NULL, armour_type VARCHAR(255) NOT NULL, armour_class_base INT DEFAULT NULL, armour_class_bonus INT DEFAULT NULL, max_dexterity_modifier INT DEFAULT NULL, min_strength INT DEFAULT NULL, stealth_disadvantage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6BF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_items ADD CONSTRAINT FK_9D20BF54126F525E FOREIGN KEY (item_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE store_items ADD CONSTRAINT FK_9D20BF544D16C4DD FOREIGN KEY (shop_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE armour ADD CONSTRAINT FK_97FCF093BF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE armour DROP FOREIGN KEY FK_97FCF093BF396750');
        $this->addSql('ALTER TABLE store_items DROP FOREIGN KEY FK_9D20BF544D16C4DD');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E6BF396750');
        $this->addSql('ALTER TABLE store_items DROP FOREIGN KEY FK_9D20BF54126F525E');
        $this->addSql('DROP TABLE armour');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE store_items');
        $this->addSql('DROP TABLE weapon');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200909200537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, item_type VARCHAR(255) NOT NULL, item_level VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, cost NUMERIC(10, 0) NOT NULL, weight INT NOT NULL, type VARCHAR(255) NOT NULL, armour_type VARCHAR(255) DEFAULT NULL, armour_class_base INT DEFAULT NULL, armour_class_bonus INT DEFAULT NULL, max_dexterity_modifier INT DEFAULT NULL, min_strength INT DEFAULT NULL, stealth_disadvantage TINYINT(1) DEFAULT NULL, weapon_type VARCHAR(255) DEFAULT NULL, damage_dice_type INT DEFAULT NULL, damage_dice_number INT DEFAULT NULL, damage_type VARCHAR(255) DEFAULT NULL, ammuntion TINYINT(1) DEFAULT NULL, finesse TINYINT(1) DEFAULT NULL, heavy TINYINT(1) DEFAULT NULL, light TINYINT(1) DEFAULT NULL, loading TINYINT(1) DEFAULT NULL, reach TINYINT(1) DEFAULT NULL, two_handed TINYINT(1) DEFAULT NULL, thrown TINYINT(1) DEFAULT NULL, short_range INT DEFAULT NULL, long_range INT DEFAULT NULL, versatile TINYINT(1) DEFAULT NULL, versatile_damage_dice INT DEFAULT NULL, versatile_damage_dice_number TINYINT(1) DEFAULT NULL, special TINYINT(1) DEFAULT NULL, special_text VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE store');
    }
}

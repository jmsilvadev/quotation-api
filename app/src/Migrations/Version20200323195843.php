<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323195843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE age_rating (age INT AUTO_INCREMENT NOT NULL, rating_factor NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(age)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO `age_rating` VALUES ('17', '1.50'), ('18', '1.40'), ('19', '1.30'), ('20', '1.20'), ('21', '1.10'), ('22', '1.00'), ('23', '0.95'), ('24', '0.90'), ('25', '0.75')");
        
        $this->addSql('CREATE TABLE postcode_rating (postcode_area VARCHAR(4) NOT NULL, rating_factor NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(postcode_area)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO `postcode_rating` VALUES ('LE10', '1.35'), ('PE3', '1.10'), ('WR2', '0.90')");

        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, policy_number VARCHAR(20) NOT NULL, age INT DEFAULT NULL, postcode VARCHAR(10) DEFAULT NULL, reg_no VARCHAR(10) DEFAULT NULL, abi_code VARCHAR(10) DEFAULT NULL, premium NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE abi_code_rating (abi_code VARCHAR(10) NOT NULL, rating_factor NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(abi_code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO `abi_code_rating` VALUES ('22529902', '0.95'), ('46545255', '1.15'), ('52123803', '1.20')");
        
        $this->addSql('CREATE TABLE base_premium (base_premium NUMERIC(10, 2) NOT NULL, PRIMARY KEY(base_premium)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO `base_premium` VALUES ('500.00')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE age_rating');
        $this->addSql('DROP TABLE postcode_rating');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE abi_code_rating');
        $this->addSql('DROP TABLE base_premium');
    }
}

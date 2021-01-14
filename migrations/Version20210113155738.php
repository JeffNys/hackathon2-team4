<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113155738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hero (id INT AUTO_INCREMENT NOT NULL,
                                            id_api VARCHAR(255) NOT NULL,
                                            name VARCHAR(255) NOT NULL,
                                            intelligence INT NOT NULL,
                                            strength INT NOT NULL,
                                            speed INT NOT NULL,
                                            durability INT NOT NULL,
                                            power INT NOT NULL,
                                            combat INT NOT NULL,
                                            publisher VARCHAR(255) NOT NULL,
                                            gender VARCHAR(255) NOT NULL,
                                            race VARCHAR(255) NOT NULL,
                                            height_cm VARCHAR(255) NOT NULL,
                                            weight VARCHAR(255) NOT NULL,
                                            image LONGTEXT NOT NULL,
                                            alignment VARCHAR(255) NOT NULL,
                                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
                                            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE hero');
    }
}

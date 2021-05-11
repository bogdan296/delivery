<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210510154418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'create table delivery_history
(
    id         int auto_increment,
    zip_code    int     not null,
    shipment_date    datetime     not null,
    delivered_date     datetime   not null,
    order_date     datetime   not null,
    INDEX       zip_code_index (zip_code),
    INDEX       order_date_index (order_date),
    primary key (id)
)
DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

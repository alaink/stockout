<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tickets`.
 */
class m160607_071154_create_tickets extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%tickets}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'product_id' => 'INT(11) NULL',
            'subdea_code' => 'VARCHAR(255) NULL',
            'product_quantity' => 'INT(11) NULL',
            'response_time_preference' => 'DATETIME NULL',
            'noticed_at' => 'DATETIME NULL',
            'comments' => 'TEXT NULL',
            'status_subdea' => 'ENUM(\'0\',\'1\',\'2\',\'\') NOT NULL DEFAULT \'0\'',
            'status_fmcg' => 'ENUM(\'0\',\'1\',\'2\',\'\') NOT NULL DEFAULT \'0\'',
        ]);

        $this->createIndex('idx_user_id_1167_00','tickets','user_id',0);
        $this->createIndex('idx_product_id_1167_01','tickets','product_id',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_products_1163_00','{{%tickets}}', 'product_id', '{{%products}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_user_1164_01','{{%tickets}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tickets');
    }
}

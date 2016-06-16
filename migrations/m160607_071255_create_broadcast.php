<?php

use yii\db\Migration;

/**
 * Handles the creation for table `broadcast`.
 */
class m160607_071255_create_broadcast extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%broadcast}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'title' => 'TEXT NULL',
            'message' => 'TEXT NULL',
            'product_id' => 'INT(11) NULL',
        ]);

        $this->createIndex('idx_user_id_1661_00','broadcast','user_id',0);
        $this->createIndex('idx_product_id_1661_01','broadcast','product_id',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_user_1659_00','{{%broadcast}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_products_1659_01','{{%broadcast}}', 'product_id', '{{%products}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('broadcast');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation for table `action_undertaken`.
 */
class m160607_071416_create_action_undertaken extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%action_undertaken}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'product_id' => 'INT(11) NOT NULL',
            'product_delivered' => 'INT(11) NULL',
            'product_picked' => 'INT(11) NULL',
            'pickup_underway' => 'INT(11) NULL',
            'delivery_underway' => 'INT(11) NULL',
            'stock_ordered' => 'INT(11) NULL',
        ]);

        $this->createIndex('idx_user_id_3633_00','action_undertaken','user_id',0);
        $this->createIndex('idx_product_id_3633_01','action_undertaken','product_id',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_user_3623_00','{{%action_undertaken}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_products_3623_01','{{%action_undertaken}}', 'product_id', '{{%products}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('action_undertaken');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation for table `products`.
 */
class m160607_071033_create_products extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%products}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'name' => 'VARCHAR(255) NOT NULL',
            'fmcg_code' => 'VARCHAR(255) NOT NULL',
        ]);

        $this->createIndex('idx_fmcg_code_0026_00','products','fmcg_code',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_user_profile_0023_00','{{%products}}', 'fmcg_code', '{{%user_profile}}', 'user_code', 'RESTRICT', 'RESTRICT' );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('products');
    }
}

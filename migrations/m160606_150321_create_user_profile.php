<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_profile`.
 */
class m160606_150321_create_user_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'profile_type_id' => 'INT(11) NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'user_code' => 'VARCHAR(255) NULL',
            'rating' => 'INT(11) NULL',
            'tel_address' => 'VARCHAR(30) NULL',
            'location' => 'VARCHAR(255) NULL',
        ]);

        $this->createIndex('idx_user_code_8624_01','user_profile','user_code',0);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_profile');
    }
}

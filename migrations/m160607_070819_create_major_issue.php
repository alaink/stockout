<?php

use yii\db\Migration;

/**
 * Handles the creation for table `major_issue`.
 */
class m160607_070819_create_major_issue extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%major_issue}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'name' => 'VARCHAR(45) NOT NULL',
        ]);

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%major_issue}}',['id'=>'1','name'=>'stock_issue']);
        $this->insert('{{%major_issue}}',['id'=>'2','name'=>'product_issue']);
        $this->insert('{{%major_issue}}',['id'=>'3','name'=>'client_complaint']);
        $this->insert('{{%major_issue}}',['id'=>'4','name'=>'other_issues']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('major_issue');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation for table `province`.
 */
class m160705_081017_create_province extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('province', [
            'id' => $this->primaryKey(),
            'name' => 'VARCHAR(75) NOT NULL',
        ]);

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%province}}',['id'=>'1','name'=>'Kigali City']);
        $this->insert('{{%province}}',['id'=>'2','name'=>'Southern Province']);
        $this->insert('{{%province}}',['id'=>'3','name'=>'Western Province']);
        $this->insert('{{%province}}',['id'=>'4','name'=>'Northern Province']);
        $this->insert('{{%province}}',['id'=>'5','name'=>'Eastern Province']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('province');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation for table `issue`.
 */
class m160628_081424_create_issue extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('issue', [
            'issue_id' => $this->primaryKey(),
            'name' => 'VARCHAR(45) NOT NULL',
        ]);

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%issue}}',['issue_id'=>'1','name'=>'Stock Issue']);
        $this->insert('{{%issue}}',['issue_id'=>'2','name'=>'Product Issue']);
        $this->insert('{{%issue}}',['issue_id'=>'3','name'=>'Other Issues']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('issue');
    }
}

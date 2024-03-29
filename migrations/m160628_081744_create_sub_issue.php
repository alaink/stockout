<?php

use yii\db\Migration;

/**
 * Handles the creation for table `sub_issue`.
 */
class m160628_081744_create_sub_issue extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sub_issue', [
            'sub_issue_id' => $this->primaryKey(),
            'issue_id' => 'INT(11) NOT NULL',
            'name' => 'VARCHAR(45) NOT NULL',
        ]);

        $this->createIndex('idx-sub_issue-issue_id','sub_issue','issue_id');
        $this->addForeignKey(
            'fk-sub_issue-issue_id',
            'sub_issue',
            'issue_id',
            'issue',
            'issue_id',
            'CASCADE'
        );

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%sub_issue}}',['sub_issue_id'=>'1','issue_id'=>'1', 'name'=>'Running Out']);
        $this->insert('{{%sub_issue}}',['sub_issue_id'=>'2','issue_id'=>'1','name'=>'Out of Stock']);
        $this->insert('{{%sub_issue}}',['sub_issue_id'=>'3','issue_id'=>'1','name'=>'Need New Product']);
        $this->insert('{{%sub_issue}}',['sub_issue_id'=>'4','issue_id'=>'2','name'=>'Product Expired']);
        $this->insert('{{%sub_issue}}',['sub_issue_id'=>'5','issue_id'=>'2','name'=>'Product Damaged']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sub_issue');
    }
}

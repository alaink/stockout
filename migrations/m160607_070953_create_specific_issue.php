<?php

use yii\db\Migration;

/**
 * Handles the creation for table `specific_issue`.
 */
class m160607_070953_create_specific_issue extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%specific_issue}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'major_issue_id' => 'INT(11) NOT NULL',
            'name' => 'VARCHAR(45) NOT NULL',
        ]);

        $this->createIndex('idx_major_issue_id_1061_00','specific_issue','major_issue_id',0);

        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey('fk_major_issue_1057_00','{{%specific_issue}}', 'major_issue_id', '{{%major_issue}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('specific_issue');
    }
}

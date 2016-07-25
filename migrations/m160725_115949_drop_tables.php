<?php

use yii\db\Migration;

/**
 * Handles the dropping for table `tables`.
 */
class m160725_115949_drop_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->dropTable('major_issue');
        $this->dropTable('specific_issue');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->createTable('major_issue', [
            'id' => $this->primaryKey(),
        ]);
        $this->createTable('specific_issue', [
            'id' => $this->primaryKey(),
        ]);
    }
}

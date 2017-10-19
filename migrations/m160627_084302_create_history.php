<?php

use yii\db\Migration;

/**
 * Handles the creation for table `history`.
 */
class m160627_084302_create_history extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('history', [
            'id' => $this->primaryKey(),
            'user_id' => 'INT(11) NOT NULL',
            'action_made' => 'VARCHAR(255) NOT NULL',
            'ticket_id' => 'INT(11) NOT NULL',
            'created_at' => 'TIMESTAMP NOT NULL',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-history-user_id',
            'history',
            'user_id'
        );

        // add foreign keys for table `user`
        $this->addForeignKey(
            'fk-history-user_id',
            'history',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `ticket_id`
        $this->createIndex(
            'idx-history-ticket_id',
            'history',
            'ticket_id'
        );

        // add foreign keys for table `tickets`
        $this->addForeignKey(
            'fk-history-ticket_id',
            'history',
            'ticket_id',
            'tickets',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {

        $this->dropForeignKey(
            'fk-history-user_id',
            'history'
        );

        $this->dropIndex(
            'idx-history-user_id',
            'history'
        );

        $this->dropForeignKey(
            'fk-history-ticket_id',
            'history'
        );

        $this->dropIndex(
            'idx-history-ticket_id',
            'history'
        );

        $this->dropTable('history');
    }
}

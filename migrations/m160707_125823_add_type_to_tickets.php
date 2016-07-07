<?php

use yii\db\Migration;

/**
 * Handles adding type to table `tickets`.
 */
class m160707_125823_add_type_to_tickets extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('tickets', 'type', 'INT(11) NOT NULL');
        $this->createIndex(
            'idx-tickets-type',
            'tickets',
            'type'
        );
        $this->execute('SET foreign_key_checks = 0');
        $this->addForeignKey(
            'fk-tickets-type',
            'tickets',
            'type',
            'issue',
            'issue_id',
            'RESTRICT'
        );
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-tickets-type',
            'tickets'
        );

        $this->dropIndex(
            'idx-tickets-type',
            'tickets'
        );
        $this->dropColumn('tickets', 'type');
    }
}

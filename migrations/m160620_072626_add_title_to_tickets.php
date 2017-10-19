<?php

use yii\db\Migration;

/**
 * Handles adding title to table `tickets`.
 */
class m160620_072626_add_title_to_tickets extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('tickets', 'title', 'varchar(255)');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('tickets', 'title');
    }
}

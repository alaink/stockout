<?php

use yii\db\Migration;

/**
 * Handles adding period_delivered to table `tickets`.
 */
class m160629_115626_add_period_delivered_to_tickets extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('tickets', 'period_delivered', 'DATETIME NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('tickets', 'period_delivered');
    }
}

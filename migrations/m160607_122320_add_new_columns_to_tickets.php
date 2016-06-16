<?php

use yii\db\Migration;

/**
 * Handles adding new_columns to table `tickets`.
 */
class m160607_122320_add_new_columns_to_tickets extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('tickets', 'created_by', $this->integer());
        $this->addColumn('tickets', 'created_at', $this->datetime());
        $this->addColumn('tickets', 'updated_by', $this->integer());
        $this->addColumn('tickets', 'updated_at', $this->datetime());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('tickets', 'created_by');
        $this->dropColumn('tickets', 'created_at');
        $this->dropColumn('tickets', 'updated_by');
        $this->dropColumn('tickets', 'updated_at');
    }
}

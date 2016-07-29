<?php

use yii\db\Migration;

/**
 * Handles adding confirmed to table `partners`.
 */
class m160728_073651_add_confirmed_to_partners extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('partners', 'confirmed', 'SMALLINT(3) NOT NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('partners', 'confirmed');
    }
}

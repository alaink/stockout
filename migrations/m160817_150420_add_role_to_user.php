<?php

use yii\db\Migration;

/**
 * Handles adding role to table `user`.
 */
class m160817_150420_add_role_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'role', 'SMALLINT(3) NOT NULL DEFAULT 10');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'role');
    }
}

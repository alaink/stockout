<?php

use yii\db\Migration;

/**
 * Handles dropping user_code from table `user_profile`.
 */
class m160810_122415_drop_user_code_from_user_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('{{%user_profile}}', 'user_code');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('user_profile', 'user_code', $this->varchar(255));
    }
}

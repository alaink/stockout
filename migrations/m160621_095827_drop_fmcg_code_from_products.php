<?php

use yii\db\Migration;

/**
 * Handles dropping fmcg_code from table `products`.
 */
class m160621_095827_drop_fmcg_code_from_products extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropForeignKey('fk_user_profile_0023_00', '{{%products}}');
        $this->dropColumn('{{%products}}', 'fmcg_code');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('products', 'fmcg_code', $this->varchar(255));
    }
}

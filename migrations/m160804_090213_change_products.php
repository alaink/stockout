<?php

use yii\db\Migration;

/**
 * Handles changing columns of table `products`
 */
class m160804_090213_change_products extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%products}}', 'product');
        $this->dropColumn('{{%products}}', 'type_flavor');
        $this->dropColumn('{{%products}}', 'size');
        $this->addColumn('products', 'rrp', $this->integer());
    }

    public function down()
    {
        $this->addColumn('products', 'product', $this->varchar(255));
        $this->addColumn('products', 'type_flavor', $this->varchar(255));
        $this->addColumn('products', 'size', $this->varchar(150));
        $this->dropColumn('products', 'rrp');
    }
    
}

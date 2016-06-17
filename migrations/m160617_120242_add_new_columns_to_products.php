<?php

use yii\db\Migration;

/**
 * Handles adding new_columns to table `products`.
 */
class m160617_120242_add_new_columns_to_products extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('products', 'category', 'varchar(255)');
        $this->addColumn('products', 'product', 'varchar(255)');
        $this->addColumn('products', 'type_flavor', 'varchar(255)');
        $this->addColumn('products', 'size', 'varchar(150)');
        $this->addColumn('products', 'bar_code', 'varchar(255)');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('products', 'category');
        $this->dropColumn('products', 'product');
        $this->dropColumn('products', 'type_flavor');
        $this->dropColumn('products', 'size');
        $this->dropColumn('products', 'bar_code');
    }
}

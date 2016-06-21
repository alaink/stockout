<?php

use yii\db\Migration;

/**
 * Handles adding fmcg_id to table `products`.
 */
class m160621_120135_add_fmcg_id_to_products extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('products', 'fmcg_id', $this->integer());

        // creates index for column `fmcg_id`
        $this->createIndex(
            'idx-products-fmcg_id',
            'products',
            'fmcg_id'
        );

        // add foreign key for table `user_profile`
        $this->addForeignKey(
            'fk-products-fmcg_id',
            'products',
            'fmcg_id',
            'user_profile',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user_profile`
        $this->dropForeignKey(
            'fk-products-fmcg_id',
            'products'
        );

        // drops index for column `user_profile_id`
        $this->dropIndex(
            'idx-products-fmcg_id',
            'products'
        );
        
        $this->dropColumn('products', 'fmcg_id');
    }
}

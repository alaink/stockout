<?php

use yii\db\Migration;

/**
 * Handles the creation for table `partners`.
 */
class m160623_141100_create_partners extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('partners', [
            'id' => $this->primaryKey(),
            'from_id' => 'INT(11) NOT NULL',
            'to_id' => 'INT(11) NOT NULL'
        ]);

        // creates index for column `from_id`
        $this->createIndex(
            'idx-partners-from_id',
            'partners',
            'from_id'
        );

        // creates index for column `to_id`
        $this->createIndex(
            'idx-partners-to_id',
            'partners',
            'to_id'
        );

        // add foreign keys for table `user_profile`
        $this->addForeignKey(
            'fk-partners-from_id',
            'partners',
            'from_id',
            'user_profile',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-partners-to_id',
            'partners',
            'to_id',
            'user_profile',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-partners-from_id',
            'partners'
        );

        $this->dropForeignKey(
            'fk-partners-to_id',
            'partners'
        );

        $this->dropIndex(
            'idx-post_tag-post_id',
            'post_tag'
        );

        $this->dropIndex(
            'idx-post_tag-post_id',
            'post_tag'
        );


        $this->dropTable('partners');
    }
}

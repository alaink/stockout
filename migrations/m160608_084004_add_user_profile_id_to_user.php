<?php

use yii\db\Migration;

/**
 * Handles adding user_profile_id to table `user`.
 * Has foreign keys to the tables:
 *
 * - `user_profile`
 */
class m160608_084004_add_user_profile_id_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'user_profile_id', $this->integer());

        // creates index for column `user_profile_id`
        $this->createIndex(
            'idx-user-user_profile_id',
            'user',
            'user_profile_id'
        );

        // add foreign key for table `user_profile`
        $this->addForeignKey(
            'fk-user-user_profile_id',
            'user',
            'user_profile_id',
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
            'fk-user-user_profile_id',
            'user'
        );

        // drops index for column `user_profile_id`
        $this->dropIndex(
            'idx-user-user_profile_id',
            'user'
        );

        $this->dropColumn('user', 'user_profile_id');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding locations to table `user_profile`.
 */
class m160705_093237_add_cell_id_to_user_profile extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->dropColumn('user_profile', 'location');
        $this->addColumn('user_profile', 'cell_id', 'INT(11) NOT NULL');

        $this->createIndex(
            'idx-user_profile-cell_id',
            'user_profile',
            'cell_id'
        );

        $this->addForeignKey(
            'fk-user_profile-cell_id',
            'user_profile',
            'cell_id',
            'cell',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-user_profile-cell_id',
            'user_profile'
        );

        $this->dropIndex(
            'idx-user_profile-cell_id',
            'user_profile'
        );

        $this->dropColumn('user_profile', 'cell_id');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation for table `district`.
 */
class m160705_082826_create_district extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('district', [
            'id' => $this->primaryKey(),
            `province_id`  => 'INT(11) NOT NULL',
            `name`=> 'VARCHAR(75) NOT NULL',
        ]);
        
        $this->createIndex(
            'idx-user_profile-province_id',
            'user_profile',
            'province_id'
        );

        // add foreign key for table `user_profile`
        $this->addForeignKey(
            'fk-user_profile-province_id',
            'user_profile',
            'province_id',
            'province',
            'id',
            'RESTRICT'
        );

        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%district}}',['id'=>'1','province_id'=>'1','name'=>'Nyarugenge']);
        $this->insert('{{%district}}',['id'=>'2','province_id'=>'1','name'=>'Gasabo']);
        $this->insert('{{%district}}',['id'=>'3','province_id'=>'1','name'=>'Kicukiro']);
        $this->insert('{{%district}}',['id'=>'4','province_id'=>'2','name'=>'Nyanza']);
        $this->insert('{{%district}}',['id'=>'5','province_id'=>'2','name'=>'Gisagara']);
        $this->insert('{{%district}}',['id'=>'6','province_id'=>'2','name'=>'Nyaruguru']);
        $this->insert('{{%district}}',['id'=>'7','province_id'=>'2','name'=>'Huye']);
        $this->insert('{{%district}}',['id'=>'8','province_id'=>'2','name'=>'Nyamagabe']);
        $this->insert('{{%district}}',['id'=>'9','province_id'=>'2','name'=>'Ruhango']);
        $this->insert('{{%district}}',['id'=>'10','province_id'=>'2','name'=>'Muhanga']);
        $this->insert('{{%district}}',['id'=>'11','province_id'=>'2','name'=>'Kamonyi']);
        $this->insert('{{%district}}',['id'=>'12','province_id'=>'3','name'=>'Karongi']);
        $this->insert('{{%district}}',['id'=>'13','province_id'=>'3','name'=>'Rutsiro']);
        $this->insert('{{%district}}',['id'=>'14','province_id'=>'3','name'=>'Rubavu']);
        $this->insert('{{%district}}',['id'=>'15','province_id'=>'3','name'=>'Nyabihu']);
        $this->insert('{{%district}}',['id'=>'16','province_id'=>'3','name'=>'Ngororero']);
        $this->insert('{{%district}}',['id'=>'17','province_id'=>'3','name'=>'Rusizi']);
        $this->insert('{{%district}}',['id'=>'18','province_id'=>'3','name'=>'Nyamasheke']);
        $this->insert('{{%district}}',['id'=>'19','province_id'=>'4','name'=>'Rulindo']);
        $this->insert('{{%district}}',['id'=>'20','province_id'=>'4','name'=>'Gakenke']);
        $this->insert('{{%district}}',['id'=>'21','province_id'=>'4','name'=>'Musanze']);
        $this->insert('{{%district}}',['id'=>'22','province_id'=>'4','name'=>'Burera']);
        $this->insert('{{%district}}',['id'=>'23','province_id'=>'4','name'=>'Gicumbi']);
        $this->insert('{{%district}}',['id'=>'24','province_id'=>'5','name'=>'Rwamagana']);
        $this->insert('{{%district}}',['id'=>'25','province_id'=>'5','name'=>'Nyagatare']);
        $this->insert('{{%district}}',['id'=>'26','province_id'=>'5','name'=>'Gatsibo']);
        $this->insert('{{%district}}',['id'=>'27','province_id'=>'5','name'=>'Kayonza']);
        $this->insert('{{%district}}',['id'=>'28','province_id'=>'5','name'=>'Kirehe']);
        $this->insert('{{%district}}',['id'=>'29','province_id'=>'5','name'=>'Ngoma']);
        $this->insert('{{%district}}',['id'=>'30','province_id'=>'5','name'=>'Bugesera']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-user_profile-province_id',
            'user_profile'
        );

        $this->dropIndex(
            'idx-user_profile-province_id',
            'user_profile'
        );
        $this->dropTable('district');
    }
}

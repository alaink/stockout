<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property UserProfile[] $userProfiles
 */
class ProfileType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Profile Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['profile_type_id' => 'id']);
    }
}

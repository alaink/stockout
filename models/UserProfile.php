<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $profile_type_id
 * @property string $name
 * @property string $user_code
 * @property integer $rating
 * @property integer $tel_address
 * @property string $location
 *
 * @property Products[] $products
 * @property ProfileType $profileType
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_type_id', 'name' ], 'required'],
            [['name' ], 'required'],
            [['profile_type_id', 'rating', 'tel_address'], 'integer'],
            [['name', 'user_code', 'location'], 'string', 'max' => 255],
            [['profile_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProfileType::className(), 'targetAttribute' => ['profile_type_id' => 'id']],
            //[['profile_type_id', 'name', 'tel_address', 'location'], 'on' => 'create'],
            //[[ 'name', 'tel_address', 'location'], 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_type_id' => 'Profile Type',
            'name' => 'Name',
            'user_code' => 'User Code',
            'rating' => 'Rating',
            'tel_address' => 'Tel Address',
            'location' => 'Location',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['fmcg_code' => 'user_code']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfileType()
    {
        return $this->hasOne(ProfileType::className(), ['id' => 'profile_type_id']);
    }

    /**
     * get list of profile types for dropdown
     */
    public static function getProfileTypeList()
    {
        $droptions = ProfileType::find()->asArray()->all();
        return ArrayHelper::map($droptions, 'id', 'name');
    }

    public static function userHasProfile()
    {
        $model = UserProfile::find()->where(['id' =>
            Yii::$app->user->identity->user_profile_id])->one();
        
        if($model != null) {
            return $model['id'];
        }else {
            return false;
        }
    }
    
}

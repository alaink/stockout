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
 * @property string $cell_id
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
            [['profile_type_id', 'name', 'cell_id'], 'required'],
            [['profile_type_id', 'rating', 'tel_address', 'cell_id'], 'integer'],
            [['name', 'user_code'], 'string', 'max' => 255],
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
            'cell_id' => 'Cell',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['fmcg_code' => 'user_code']);
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

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
 * @property integer $rating
 * @property integer $tel_address
 * @property string $cell_id
 *
 * @property Products[] $products
 */
class UserProfile extends \yii\db\ActiveRecord
{
    var $district_id;
    var $sector_id;
    var $from_id;

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
            [['name'], 'string', 'max' => 255],
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
            'rating' => 'Rating',
            'tel_address' => 'Telephone N.',
            'cell_id' => 'Cell',
            'district_id' => 'District',
            'sector_id' => 'Sector',
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
//            return $model;
            return $model['id'];
        }else {
            return false;
        }
    }
    
    
    
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cell".
 *
 * @property integer $id
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $sector_id
 * @property string $name
 *
 * @property Province $province
 * @property District $district
 * @property Sector $sector
 * @property UserProfile[] $userProfiles
 */
class Cell extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cell';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'district_id', 'sector_id', 'name'], 'required'],
            [['province_id', 'district_id', 'sector_id'], 'integer'],
            [['name'], 'string', 'max' => 75],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['sector_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sector::className(), 'targetAttribute' => ['sector_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_id' => 'Province ID',
            'district_id' => 'District ID',
            'sector_id' => 'Sector ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['cell_id' => 'id']);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partners".
 *
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 */
class Partners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id'], 'required'],
            [['from_id', 'to_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
        ];
    }

    public static function savePartners($FMCGs, $to_id)
    {
        foreach ($FMCGs as $fmcg)
        {
            $model = new Partners();
            
            $model->from_id = $fmcg;
            $model->to_id = $to_id;
            $model->confirmed = 0;

            $model->save();
        }
    }

    public static function showUnconfirmedSubdealers()
    {
        $subdealers = Partners::find()
                        ->select('to_id')
                        ->where(['confirmed' => 0])
                        ->andWhere(['from_id' => Yii::$app->user->identity->user_profile_id])
                        ->all();
        
        return $subdealers;
    }
}

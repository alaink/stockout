<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

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

    public static function updatePartners($newFMCGs, $to_id)
    {
        // get all subdealer's fmcgs from db
        $savedFMCGs = array_keys(RecordHelpers::getMyFmcgs());

        // ADDING NEW FMCG
        if(is_array($newFMCGs) and is_array($savedFMCGs)) {
            foreach ($newFMCGs as $newFMCG) {
                if (!in_array($newFMCG, $savedFMCGs)) {
                    $model = new Partners();

                    $model->from_id = $newFMCG;
                    $model->to_id = $to_id;
                    $model->confirmed = 0;
                    $model->save();
                }
            }

            // DELETING FMCG
            foreach ($savedFMCGs as $savedFMCG) {
                if (!in_array($savedFMCG, $newFMCGs)) {
                    $model = Partners::find()->where([
                        'from_id' => $savedFMCG, 'to_id' => $to_id])->one();
                    $model->delete();
                }
            }
        }
//        // one new fmcg
//        elseif (!is_array($newFMCGs) and is_array($savedFMCGs)) {
//            // adding
//            if (!in_array($newFMCGs, $savedFMCGs)) {
//                $model = new Partners();
//
//                $model->from_id = $newFMCGs;
//                $model->to_id = $to_id;
//                $model->confirmed = 0;
//                $model->save();
//            }
//
//            // deleting
//            foreach ($savedFMCGs as $savedFMCG) {
//                echo $savedFMCG . ' ---- ' . $newFMCGs . '------' . '<br/>';
//                if($savedFMCG != $newFMCGs)
//                {
//                    $model = Partners::find()->where([
//                            'from_id' => $savedFMCG, 'to_id' => $to_id ])->one();
//                    //$model->delete();
//                }
//            }
//        }
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partners::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/8/16
 * Time: 3:04 PM
 */

namespace app\controllers;


use app\models\Partners;
use Yii;

class ValidateController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $subdealers = Partners::showUnconfirmedSubdealers();

        return $this->render('index', [
            'subdealers' => $subdealers
        ]);
    }

    public function actionConfirm($id)
    {
        $subdealer = Partners::findOne(['to_id' => $id, 'from_id' => Yii::$app->user->identity->user_profile_id]);

        $subdealer->confirmed = 1;
        $subdealer->save();

        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        $subdealer = Partners::findOne(['to_id' => $id, 'from_id' => Yii::$app->user->identity->user_profile_id]);

        $subdealer->confirmed = 3;
        $subdealer->save();

        return $this->redirect(['index']);
    }

}
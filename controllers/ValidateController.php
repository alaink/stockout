<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/8/16
 * Time: 3:04 PM
 */

namespace app\controllers;


use app\models\Cell;
use app\models\Partners;
use app\models\RecordHelpers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class ValidateController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'confirm','reject'],
                'rules' => [
                    [
                        'actions' => ['index', 'confirm','reject'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $subdealers = Partners::showUnconfirmedSubdealers();
        
        $data = self::formatData($subdealers);

        return $this->render('index', [
            'subdealers' => $data
        ]);
    }

    public function actionConfirm($id)
    {
        $subdealer = Partners::findOne(['to_id' => $id, 'from_id' => Yii::$app->user->identity->user_profile_id]);

        $subdealer->confirmed = 1;
        $subdealer->save();

        Yii::$app->session->setFlash('success', "Subdealer validated successfully!");
        return $this->redirect(['index']);
    }

    public function actionReject($id)
    {
        $subdealer = Partners::findOne(['to_id' => $id, 'from_id' => Yii::$app->user->identity->user_profile_id]);

        $subdealer->confirmed = 3;
        $subdealer->save();

        Yii::$app->session->setFlash('success', "Subdealer rejected successfully!");
        return $this->redirect(['index']);
    }

    public static function formatData($subdealers)
    {
        $data = [];
        $i = 0;
        foreach ($subdealers as $subdealer)
        {
            $id = $subdealer->to_id;
            $profile = RecordHelpers::getProfile($id);
            
            $name = $profile['name'];
            $phone = $profile['tel_address'];
            $cell = $profile['cell_id'];
            $district = RecordHelpers::getDistrict_Sector_FromCell($cell)->district_id;
            $sector = RecordHelpers::getDistrict_Sector_FromCell($cell)->sector_id;
            $location = RecordHelpers::getDistrictName($district) . ' : ' . RecordHelpers::getSectorName($sector);
            
            $data[$i]['id'] = $id;
            $data[$i]['name'] = $name;
            $data[$i]['phone'] = $phone;
            $data[$i]['location'] = $location;

            $i++;
        }
        
        return $data;
    }

}
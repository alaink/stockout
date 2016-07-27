<?php

namespace app\controllers;

use app\models\UploadForm;
use Yii;
use app\models\Products;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class ProductsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * uploads a products's file
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->uploadedFile = UploadedFile::getInstance($model, 'uploadedFile');

            if ($model->upload()) {

                $inputFile = \Yii::$app->basePath .'/web/uploads/' . $model->uploadedFile->baseName . '.' . $model->uploadedFile->extension;

                Products::importExcel($inputFile);

                Yii::$app->session->setFlash('success', "Products saved successfully!");
                return $this->redirect(['index']);

            }
        }
        
        return $this->render('index', [
            'model' => $model
        ]);
    }

}

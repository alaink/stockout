<?php

namespace app\controllers;

use app\models\RecordHelpers;
use app\models\UploadForm;
use Yii;
use app\models\Products;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\User;

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
                        'matchCallback' => function ($rule, $action) {
                            return User::isUserAdmin(Yii::$app->user->identity->username);
                        }
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
        $productsModel = new Products();
        $allFMCGs = RecordHelpers::getFmcgs();

        if (Yii::$app->request->isPost) {
            $model->uploadedFile = UploadedFile::getInstance($model, 'uploadedFile');
            /* fmcg selected */
            $POST_VAR = Yii::$app->request->post('Products');
            $fmcg = $POST_VAR['fmcg'];

            if ($model->upload()) {

                $inputFile = \Yii::$app->basePath .'/web/uploads/' . $model->uploadedFile->baseName . '.' . $model->uploadedFile->extension;

                Products::importExcel($inputFile, $fmcg);

                Yii::$app->session->setFlash('success', "Products saved successfully!");
                return $this->redirect(['index']);

            }
        }
        
        return $this->render('index', [
            'model' => $model,
            'productsModel' => $productsModel,
            'allFMCGs' => $allFMCGs
        ]);
    }

}

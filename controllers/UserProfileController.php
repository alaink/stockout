<?php

namespace app\controllers;

use Yii;
use app\models\UserProfile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RecordHelpers;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view','create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view','create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * view current user's profile or send user to create one.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($already_exists = RecordHelpers::userHas('user-profile')) {
            return $this->render('view', [
                'model' => $this->findModel($already_exists),
            ]);
        } else {
            return $this->redirect(['create']);
        }
    }

    /**
     * Displays a single UserProfile model. same as actionIndex
     * @return mixed
     */
    public function actionView()
    {
        //if ($already_exists = RecordHelpers::userHas('user-profile')) {
        if($already_exists = UserProfile::userHasProfile()){
            return $this->render('view', [
                'model' => $this->findModel($already_exists),
            ]);
        } else {
            return $this->redirect(['create']);
        }
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserProfile();
        $model->scenario = 'create';

        //$model->user_id = Yii::$app->user->identity->id;

        // enable to have create options in other places than index or view
        if ($already_exists = UserProfile::userHasProfile()) {
            return $this->render('view', [
                'model' => $this->findModel($already_exists),
            ]);
        }
        elseif ($model->load(Yii::$app->request->post()) && $model->save()){
            
            return $this->redirect(['view']);
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        if($model = UserProfile::find()->where(['id' =>
            Yii::$app->user->identity->user_profile_id])->one()) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                // generate user_code from inputed data
                $model->user_code =  RecordHelpers::generateCodes($model->profile_type_id, $model->name,
                    Yii::$app->user->identity->id);

                $model->save();
                return $this->redirect(['view']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new NotFoundHttpException('No Such Profile.');
        }
    }

    /**
     * Deletes an existing UserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionDelete()
    {
        $model =
            Profile::find()->where([
                'user_id' => Yii::$app->user->identity->id
            ])->one();
        $this->findModel($model->id)->delete();
        return $this->redirect(['site/index']);
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
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use app\models\Partners;
use Yii;
use app\models\UserProfile;
use yii\helpers\Json;
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
        if ($already_exists = UserProfile::userHasProfile()) {
            return $this->redirect(['view']);
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
        if($already_exists = UserProfile::userHasProfile()):

            $myFMCG = '';
            if(RecordHelpers::getProfileType() == Yii::$app->params['SUBDEALER']):
                $myFMCG = RecordHelpers::getMyFmcgs();
            endif;

            $model = $this->findModel($already_exists);
            $model->district_id = RecordHelpers::getDistrictName(RecordHelpers::getDistrict_Sector_FromCell($model->cell_id)->district_id);
            $model->sector_id = RecordHelpers::getSectorName(RecordHelpers::getDistrict_Sector_FromCell($model->cell_id)->sector_id);

            return $this->render('view', [
                'model' => $model,
                'myFMCG' => $myFMCG,
            ]);
        else:
            return $this->redirect(['create']);
        endif;
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
            if ($model->load(Yii::$app->request->post()) && $model->validate()) 
            {
                $POST_VAR = Yii::$app->request->post('UserProfile');
                $fmcgs = $POST_VAR['from_id'];
                Partners::updatePartners($fmcgs, Yii::$app->user->identity->user_profile_id);
                $model->save();
                return $this->redirect(['view']);
            } else {
                $cell = $model->cell_id;
                $district_id = RecordHelpers::getDistrict_Sector_FromCell($cell)->district_id;
                $sector_id = RecordHelpers::getDistrict_Sector_FromCell($cell)->sector_id;
                $model->district_id = $district_id;
                $model->sector_id = $sector_id;
                $model->from_id = array_keys(RecordHelpers::getMyFmcgs());
                //print_r(array_keys($model->from_id));

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

    public function actionSector()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $district_id = $parents[0];
                $out = RecordHelpers::getSectors($district_id);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionCell()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $sector_id = $parents[0];
                $out = RecordHelpers::getCells($sector_id);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionList()
    {
        $allFMCGs = UserProfile::find()->select("name, tel_address")
                                ->where(['profile_type_id' => Yii::$app->params['FMCG']])->all();

        return $this->render('list', [
            'allFMCGs' => $allFMCGs,
        ]);
    }
}

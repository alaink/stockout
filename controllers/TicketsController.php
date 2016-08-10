<?php

namespace app\controllers;
use app\models\Issue;
use app\models\Products;
use app\models\RecordHelpers;
use app\models\SubIssue;
use app\models\Tickets;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class TicketsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'choose', 'list', 'update', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'choose', 'list', 'update', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $profile_type =  RecordHelpers::getProfileType();
        $model = new Tickets();
        $tickets = new Tickets();
        $fmcgSelected = '';
        $message = '';

        $ticket_status = Yii::$app->request->get('status');

        if($profile_type == Yii::$app->params['SUBDEALER']):
            // get fmcg from user from navigation panel
            $fmcgSelected = Yii::$app->request->get('fmcgSelected');

            if($fmcgSelected != null or $ticket_status != null):
                $tickets = RecordHelpers::ticketsByFmcgByDistrict($fmcgSelected, $ticket_status);
            else: 
                $message = "Select an FMCG to view his tickets!";
            endif;
        
        else: // user is an FMCG
            if($ticket_status != null):
                $tickets = RecordHelpers::ticketsForFmcg($ticket_status);
            else: // display all
                $tickets = RecordHelpers::ticketsForFmcg($ticket_status);
            endif;
            
        endif;

        $dataProvider = new ActiveDataProvider([
            'query' => $tickets,
            'pagination' => ['pageSize' =>15],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'profile_type' => $profile_type,
            'ticket_status' => $ticket_status,
            'message' => $message,
            'fmcgSelected' => $fmcgSelected,
        ]);
    }

    public function actionCreate()
    {
        $model = new Tickets();

        $products = new Products();

        // from choose view
        $issue_id = Yii::$app->request->get('id');
        $sub_issues = RecordHelpers::getSubIssues($issue_id);

        $POST_VAR = Yii::$app->request->post('Tickets');
        $POST_VAR2 = Yii::$app->request->post('Products');

        // get products data concatenated with their bar code
        $products_bar_code = RecordHelpers::getProducts();


        if ($model->load(Yii::$app->request->post()))
        {
            $model->user_id = Yii::$app->user->identity->id;
            $model->created_by = $model->user_id;
            if($issue_id != Yii::$app->params['OTHER_ISSUE']) {
                $model->product_id = RecordHelpers::retrieveProductId($POST_VAR2['bar_code']);
            }
            $model->title = RecordHelpers::createTicketTitle($issue_id, $POST_VAR);
            $model->type = $issue_id;

            $model->save();
            RecordHelpers::createHistory($model->id, 'create');

            return $this->redirect(['view', 'id' => $model->id]);
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'issue_id' => $issue_id,
                'sub_issues' => $sub_issues,
                'products' => $products,
                'products_bar_code' => $products_bar_code,
            ]);
        }
    }

    public function actionChoose()
    {
        $model = new Tickets();
        $issues = ArrayHelper::map(Issue::find()->all(), 'issue_id', 'name');

        return $this->render('choose', [
            'model' => $model,
            'issues' => $issues,
        ]);
    }

    public function actionLists()
    {
        $id = Yii::$app->request->get('id');
        
        $sub_issues = SubIssue::find()
            ->where(['issue_id' => $id])
            ->all();

        if(!empty($sub_issues))
        {
            foreach ($sub_issues as $sub_issue){
                echo "<option value='" .$sub_issue->sub_issue_id."'>".$sub_issue->name."</option>";
            }
        }else{
            echo "<option>-<option>";
        }
    }
    
    /**
     * change ticket status to in progress
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        // change status to in progress only if not viewed before hand
        if(RecordHelpers::getCurrentTicketStatus($id) < Yii::$app->params['IN_PROGRESS_TICKET']) {
            RecordHelpers::changeTicketStatus($id, Yii::$app->params['IN_PROGRESS_TICKET']);
        }

        RecordHelpers::createHistory($id, 'progress');

        $currentTicketStatus  = RecordHelpers::getCurrentTicketStatus($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'currentTicketStatus' => $currentTicketStatus
        ]);
    }

    /**
     * Displays a single Tickets model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        // change status to viewed only if not viewed before hand
        if (RecordHelpers::getCurrentTicketStatus($id) < Yii::$app->params['VIEWED_TICKET']) {
            RecordHelpers::changeTicketStatus($id, Yii::$app->params['VIEWED_TICKET']);
        }
        // process this $viewed so that it never get past 5, "memory"

        RecordHelpers::createHistory($id, 'view');

        $currentTicketStatus  = RecordHelpers::getCurrentTicketStatus($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'currentTicketStatus' => $currentTicketStatus
        ]);
    }
    
    /**
     * Finds the Tickets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tickets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tickets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

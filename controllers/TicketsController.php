<?php

namespace app\controllers;
use app\models\Products;
use app\models\RecordHelpers;
use app\models\Tickets;
use app\models\User;
use app\models\UserProfile;
use \app\models\MajorIssue;
use Yii;
use yii\helpers\ArrayHelper;

class TicketsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $profile_type =  RecordHelpers::getProfileType();
        $status_col = RecordHelpers::getTicketStatusCol();
        $user_id = Yii::$app->user->identity->id;

        // get ticket status from user
        $ticket_status = Yii::$app->request->get('status');
        $model = new Tickets();

        if($ticket_status != null)
        {
            $tickets = Tickets::find()
                ->where([$status_col => $ticket_status,
                    'user_id' => $user_id])
                ->all();
        }
        else{
            $tickets = Tickets::find()
                ->where(['user_id' => $user_id])
                ->all();
        }

        return $this->render('index', [
            'tickets' => $tickets,
            'model' => $model,
            'profile_type' => $profile_type,
            'ticket_status' => $ticket_status
        ]);
    }

    public function actionCreate()
    {
        $model = new Tickets();

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->user_id = Yii::$app->user->identity->id;
            $model->created_by = $model->user_id;

            $model->save();
            RecordHelpers::createHistory($model->id, 'create');
            
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

//    public function actionSomething()
//    {
//        $major_issues = ArrayHelper::map(MajorIssue::find()->all(), 'id', 'name');
//
//        return $this->render('something', [
//            'major_issues' => $major_issues,
//        ]);
//    }

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
        if(RecordHelpers::getCurrentTicketStatus($id) < Yii::$app->params['VIEWED_TICKET']) {
            RecordHelpers::changeTicketStatus($id, Yii::$app->params['VIEWED_TICKET']);
        }
        
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

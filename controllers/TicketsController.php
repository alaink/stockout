<?php

namespace app\controllers;
use app\models\Products;
use app\models\RecordHelpers;
use app\models\Tickets;
use app\models\User;
use app\models\UserProfile;
use Yii;

class TicketsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $profile_type =  RecordHelpers::getProfileType();
        
        //$status_col = RecordHelpers::getTicketStatusCol($profile_type);
        $status_col = RecordHelpers::getTicketStatusCol();

        // get ticket status from user
        $ticket_status = Yii::$app->request->get('status');
        $model = new Tickets();

        if($ticket_status != null)
        {
            $tickets = Tickets::find()
                ->where([$status_col => $ticket_status])
                ->all();
        }
        else{
            $tickets = Tickets::find()->all();
        }

        return $this->render('index', [
            'tickets' => $tickets,
            'model' => $model,
            'profile_type' => $profile_type,
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
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
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

        $currentTicketStatus  = RecordHelpers::getCurrentTicketStatus($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'currentTicketStatus' => $currentTicketStatus
        ]);
        
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post())) {
//            $model->updated_by = Yii::$app->user->identity->id;
//            $model->save();
//
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
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


//    public function actionSearch()
//    {
//        $ticket_status = Yii::$app->request->get('status');
//
//        // get the user model
//        $user = User::findOne(Yii::$app->user->identity->id);
//        // get his/her profile type id
//        $user_profile = UserProfile::findOne(['id' => $user->user_profile_id]);
//        $profile_type = $user_profile->profile_type_id;
//
//        $status_col = RecordHelpers::getTicketStatusCol($profile_type);
//
//        $tickets = Tickets::find()
//            ->where([$status_col => $ticket_status])
//            ->all();
//
//        return $this->render('index', [
//            'tickets' => $tickets,
//        ]);
//    }

}

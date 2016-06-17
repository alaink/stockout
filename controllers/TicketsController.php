<?php

namespace app\controllers;
use app\models\RecordHelpers;
use app\models\Tickets;
use app\models\User;
use app\models\UserProfile;
use Yii;

class TicketsController extends \yii\web\Controller
{
    public function actionIndex()
    {

        // get the user model
        $user = User::findOne(Yii::$app->user->identity->id);

        // get his/her profile type id
        $user_profile = UserProfile::findOne(['id' => $user->user_profile_id]);
        $profile_type = $user_profile->profile_type_id;
        
        $status_col = RecordHelpers::getTicketStatusCol($profile_type);
//        echo $status_col;
//        exit(0);

        $model = new Tickets();

        $tickets = Tickets::find()->all();

        $ticket_status = Yii::$app->request->get('status');
        echo $ticket_status;

        if($ticket_status)
        {
            $tickets = Tickets::find()
                ->where([$status_col => $ticket_status])
                ->all();
        }
        else{
            $tickets = Tickets::find()->all();
        }
        
        


//        // list tickets for subdealers
//        if($profile_type_id == Yii::$app->params['SUBDEALER']):
//
//            $tickets = Tickets::getTicketsByStatus('status_subdea');
//        // list tickets for fmcg
//        else :
//            // list (find) tickets where status_fmcg = $status
//            $tickets = Tickets::getTicketsByStatus('status_fmcg');
//
//        endif;


        return $this->render('index', [
            'tickets' => $tickets,
            'model' => $model,
            //'status_col' => $status_col
        ]);
    }

    public function actionSearch()
    {
        $ticket_status = Yii::$app->request->get('status');

        // get the user model
        $user = User::findOne(Yii::$app->user->identity->id);
        // get his/her profile type id
        $user_profile = UserProfile::findOne(['id' => $user->user_profile_id]);
        $profile_type = $user_profile->profile_type_id;

        $status_col = RecordHelpers::getTicketStatusCol($profile_type);

        $tickets = Tickets::find()
            ->where([$status_col => $ticket_status])
            ->all();

        return $this->render('index', [
            'tickets' => $tickets,
        ]);
    }

}

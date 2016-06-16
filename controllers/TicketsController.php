<?php

namespace app\controllers;
use app\models\Tickets;
use app\models\User;
use Yii;

class TicketsController extends \yii\web\Controller
{
    public function actionIndex()
    {

        // get the user model
        $user = User::findOne(Yii::$app->user->identity);

        // get his/her profile type id
        $profile_type_id = $user->userProfile->profile_type_id;

        // list tickets for subdealers
        if($profile_type_id == Yii::$app->params['RETAILER']):

            $tickets = Tickets::getTicketsByStatus('status_subdea');
        // list tickets for fmcg
        else :
            // list (find) tickets where status_fmcg = $status
            $tickets = Tickets::getTicketsByStatus('status_fmcg');

        endif;


        return $this->render('index', [
            'tickets' => $tickets,
        ]);
    }

}

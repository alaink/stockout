<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/14/16
 * Time: 3:40 PM
 */

namespace app\commands;
use app\models\RecordHelpers;
use app\models\Tickets;
use Yii;
use yii\base\Controller;
use yii\db\Query;

class PendingController extends Controller
{
    public function actionPending()
    {
//        $status_col = RecordHelpers::getTicketStatusCol();
//
//        $query = new Query;
//
//        $tickets = $query
//            ->select('`tickets`.`id`')
//            ->addSelect('`tickets`.`created_at`')
//            ->from('`tickets`, `products`')
//            ->where('`tickets`.`product_id` = `products`.`id`')
//            ->andWhere('`products`.`fmcg_id`= ' . Yii::$app->user->identity->user_profile_id)
//            ->andWhere(('`tickets`.' . $status_col . ' = 1 OR `tickets`.' . $status_col . ' = 3'))
//            ->all();


        $query = new Query();
//        @todo do this even for subdealers
        $tickets = $query
            ->select('`id`, `created_at`, `status_fmcg`')
            ->from('`tickets`')
            ->where(('`status_fmcg` = 1 OR `status_fmcg` = 3'))
            ->all();

        foreach ($tickets as $row)
        {
            $now = time();
            $created_at = strtotime($row['created_at']);
            $diffDays = ($now - $created_at) / 60 / 60 / 24;
            if($diffDays >= 2)
            {
                //RecordHelpers::changeTicketStatus($row['id'], Yii::$app->params['PENDING_TICKET']);
                $ticket = Tickets::findOne(['id' => $row['id']]);

                $ticket->status_fmcg = Yii::$app->params['PENDING_TICKET'];
                $ticket->save();
            }
        }
    }

}
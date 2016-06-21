<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/13/16
 * Time: 10:42 AM
 */

namespace app\models;
use yii;

class RecordHelpers
{
    public static function userHas($model_name)
    {
        $connection = \Yii::$app->db;

        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_name WHERE user_id=:userid";
        $command = $connection->createCommand($sql);
        $command->bindValue(":userid", $userid);
        $result = $command->queryOne();
        if ($result == null) {
            return false;
        } else {
            return $result['id'];
        }
    }

    /**
     * generate codes for user-code
     * @param $type 3 first letters of a profile type
     * @param $name of the user/company
     * @param $userId from the login
     */
    public function generateCodes($type, $name)
    {
        if($type == Yii::$app->params['RETAILER']){
            $initialCode = 'RET';
        }elseif($type == Yii::$app->params['SUBDEALER']){
            $initialCode = 'SUB';
        }else{
            $initialCode = 'FMCG';
        }

        $code = $initialCode . '-' . trim(strtoupper(substr($name,0,4)));
        
        return $code;

    }

    /**
     * returns the ticket status column to fetch from
     */
    //public function getTicketStatusCol($profile_type)
    public function getTicketStatusCol()
    {
        $profile_type = RecordHelpers::getProfileType();
        
        
        if($profile_type == Yii::$app->params['SUBDEALER']){
            $status_col = 'status_subdea';
        }else{
            $status_col = 'status_fmcg';
        }

        return $status_col;
    }

    public function getProductName()
    {
        $product = Products::findOne(['id' => product_id]);

        if($product)
        {
            echo "amazo";
        }else{echo "jjjj";}
        exit(0);

        return $product->name;
    }

    /**
     * returns the profile type of a user
     * @return int
     */
    public function getProfileType()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user_profile = UserProfile::findOne(['id' => $user->user_profile_id]);
        $profile_type = $user_profile->profile_type_id;
        
        return $profile_type;
    }

    /**
     * @param $id of the model
     * @param $newStatus    
     */
    public function changeTicketStatus($id, $newStatus)
    {
        // user's profile type to either change status_fmcg or status_subdea
        $profile_type =  RecordHelpers::getProfileType();

        //$status_col = RecordHelpers::getTicketStatusCol($profile_type);
        $status_col = RecordHelpers::getTicketStatusCol();

        $ticket = Tickets::findOne(['id' => $id]);

        if($newStatus == Yii::$app->params['VIEWED_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['VIEWED_TICKET'];
            $ticket->save();
        }
        else if($newStatus == Yii::$app->params['PENDING_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['PENDING_TICKET'];
            $ticket->save();
        }
        else if($newStatus == Yii::$app->params['IN_PROGRESS_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['IN_PROGRESS_TICKET'];
            $ticket->save();
        }
        else if($newStatus == Yii::$app->params['RESOLVED_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['RESOLVED_TICKET'];
            $ticket->save();
        }
        else// if($newStatus == Yii::$app->params['CLOSED_TICKET'])
        {
            $ticket->$status_col = Yii::$app->params['CLOSED_TICKET'];
            $ticket->save();
        }
    }

    public function getCurrentTicketStatus($id)
    {
        $status_col = RecordHelpers::getTicketStatusCol();

        $ticket = Tickets::findOne(['id' => $id]);
        $currentTicketStatus = $ticket->$status_col;
        
        return $currentTicketStatus;
    }
    
}
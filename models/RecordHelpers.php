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
    public function getTicketStatusCol($profile_type)
    {
        if($profile_type == Yii::$app->params['SUBDEALER']){
            $status_col = 'status_subdea';
        }else{
            $status_col = 'status_fmcg';
        }

        return $status_col;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/13/16
 * Time: 11:46 AM
 */

namespace app\models;

use yii;
use yii\helpers\Url;

class PermissionHelpers
{
    // not working for User-Profile
    public static function userMustBeOwner($model_name, $model_id)
    {
        $connection = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_name
                  WHERE user_id=:userid AND id=:model_id";

        $command = $connection->createCommand($sql);
        $command->bindValue(":userid", $userid);
        $command->bindValue(":model_id", $model_id);
        if($result = $command->queryOne()) {
            return true;
        } else {
            return false;
        }
    }
}
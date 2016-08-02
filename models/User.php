<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 8/1/16
 * Time: 9:24 AM
 */

namespace app\models;

//use Yii;
use dektrium\user\models\User as BaseUser;

class User extends BaseUser
{
    public function rules()
    {
        $rules = parent::rules();

        //$rules[] = ['user_profile_id', 'required'];
        $rules[]   = ['user_profile_id', 'integer'];

        return $rules;
    }
}
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
    const ROLE_USER = 10;
    const ROLE_ADMIN = 20;

    public function rules()
    {
        $rules = parent::rules();

        //$rules[] = ['user_profile_id', 'required'];
        $rules[]   = ['user_profile_id', 'integer'];
        $rules[]   = ['role', 'default', 'value' => 10];
        $rules[]   = ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]];

        return $rules;
    }

    public static function isUserAdmin($username)
    {
        if (static::findOne(['username' => $username, 'role' => self::ROLE_ADMIN])){

            return true;
        } else {

            return false;
        }

    }
}
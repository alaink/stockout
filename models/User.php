<?php

namespace app\models;

use Yii;
use dektrium\user\models\User as BaseUser;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $user_profile_id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $confirmed_at
 * @property string $unconfirmed_email
 * @property integer $blocked_at
 * @property string $registration_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 *
 * @property ActionUndertaken[] $actionUndertakens
 * @property Broadcast[] $broadcasts
 * @property Profile $profile
 * @property SocialAccount[] $socialAccounts
 * @property Tickets[] $tickets
 * @property Token[] $tokens
 * @property UserProfile $userProfile
 */
class User extends BaseUser
{

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add user_profile_id to scenarios
        $scenarios['create'][]   = 'user_profile_id';
        $scenarios['update'][]   = 'user_profile_id';
        $scenarios['register'][] = 'user_profile_id';
        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();

        //$rules[] = ['user_profile_id', 'required'];
        $rules[]   = ['user_profile_id', 'integer'];

        return $rules;
    }

    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['id' => 'user_profile_id']);
    }

}

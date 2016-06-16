<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/16/16
 * Time: 11:29 AM
 */

namespace app\models;

use app\models\UserProfile;
use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;
use app\models\RecordHelpers;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     *  new fields for userProfile tbl
     */
    public $profile_type_id;
    public $name;
    public $tel_address;
    public $location;
    public $user_code;

    // new field for user tbl
    public $user_profile_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['profile_type_id', 'name', ], 'required'];
        $rules[] = [['profile_type_id', 'tel_address', 'user_profile_id' ], 'integer'];
        $rules[] = [['name', 'location','user_code'], 'string', 'max' => 255];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = \Yii::t('user', 'Name');
        $labels['profile_type_id'] = \Yii::t('user', 'Profile Type');
        $labels['tel_address'] = \Yii::t('user', 'Tel address');
        $labels['location'] = \Yii::t('user', 'Location');
        $labels['user_code'] = \Yii::t('user', 'User Code');
        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(User $user)
    {
        /** @var UserProfile $profile */
        $profile = \Yii::createObject(UserProfile::className());
        $profile->setAttributes([
            'name' => $this->name,
            'profile_type_id' => $this->profile_type_id,
            'user_code' =>  RecordHelpers::generateCodes($this->profile_type_id, $this->name),
            'tel_address' => $this->tel_address,
            'location' => $this->location,
        ]);
        $profile->save(false);

        //save user
        if(!$this->user_profile_id) {

            $user->setAttributes([
                'email' => $this->email,
                'username' => $this->username,
                'password' => $this->password,
                'user_profile_id' => $profile->id,
            ]);
        }else{
            return false;
        }
        

    }

}
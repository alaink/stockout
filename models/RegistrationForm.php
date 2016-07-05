<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/16/16
 * Time: 11:29 AM
 */

namespace app\models;

use app\models\Partners;
use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;
use app\models\RecordHelpers;
use yii\helpers\ArrayHelper;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     *  new fields for userProfile tbl
     */
    public $profile_type_id;
    public $name;
    public $tel_address;
    public $user_code;
    public $district;
    public $sector;
    public $cell_id;

    // new field for user tbl
    public $user_profile_id;

    // new field for partners tbl
    public $fmcg;
    public $from_id;
    public $to_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['profile_type_id', 'name', 'cell_id'], 'required'];
        $rules[] = [['profile_type_id', 'tel_address', 'user_profile_id', 'cell_id'], 'integer'];
        $rules[] = [['name', 'location','user_code'], 'string', 'max' => 255];
        //$rules[] = [['from_id'], 'safe'];
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
        $labels['user_code'] = \Yii::t('user', 'User Code');
//        $labels['district'] = \Yii::t('user', 'District');
//        $labels['sector'] = \Yii::t('user', 'Sector');
        $labels['cell_id'] = \Yii::t('user', 'Cell');

        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(User $user)
    {
//        $POST_VAR = Yii::$app->request->post('User');
//        echo ($POST_VAR['from_id']); exit(0);
        //print_r($this->from_id) ; exit(0);
        echo ($this->name); exit(0);

        /** @var UserProfile $profile */
        $profile = \Yii::createObject(UserProfile::className());
        $profile->setAttributes([
            'name' => $this->name,
            'profile_type_id' => $this->profile_type_id,
            'user_code' =>  RecordHelpers::generateCodes($this->profile_type_id, $this->name),
            'tel_address' => $this->tel_address,
            'cell_id' => $this->cell_id,
        ]);
        $profile->save();

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

////        echo $user->id; exit(0);
////        echo "blblbbl"; exit(0);
//        // saving to partners table
//        //if($user->id) {
//            $partners = \Yii::createObject(Partners::className());
//            $partners->setAttributes([
//                'from_id' => $this->from_id,
//                'to_id' => $profile->id,
//            ]);
//            $partners->save();
//        //}

    }
    
    public function getFmcgs()
    {
        $profiles= UserProfile::find()
            ->where(['profile_type_id' => 3])
            -> all();

        $fmcgs = ArrayHelper::map($profiles, 'id', 'name');

        return $fmcgs;
    }

}
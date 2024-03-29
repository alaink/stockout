<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/16/16
 * Time: 11:29 AM
 */

namespace app\models;

use Yii;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
//use dektrium\user\models\User;
use yii\helpers\ArrayHelper;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     *  new fields for userProfile tbl
     */
    public $profile_type_id;
    public $name;
    public $tel_address;
    public $district_id;
    public $sector_id;
    public $cell_id;

    // new field for user tbl
    public $user_profile_id;

    // new field for partners tbl
    public $from_id;
    public $to_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['profile_type_id', 'name', 'cell_id'], 'required'];
        $rules[] = [['profile_type_id', 'tel_address', 'user_profile_id', 'cell_id', 'district_id', 'sector_id'], 'integer'];
        $rules[] = [['name'], 'string', 'max' => 255];
        $rules[] = [['from_id'], 'safe'];
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
        $labels['district_id'] = \Yii::t('user', 'District');
        $labels['sector_id'] = \Yii::t('user', 'Sector');
        $labels['cell_id'] = \Yii::t('user', 'Cell');

        return $labels;
    }

    /**
     * @inheritdoc
     */
    protected function loadAttributes(\dektrium\user\models\User $user)
    {
        //        $POST_VAR = Yii::$app->request->post('User');
        //        echo ($POST_VAR['from_id']); exit(0);
        //        print_r($this->from_id) ;
        //echo ($this->district_id); exit(0);
        

        /** @var UserProfile $profile */
        $profile = \Yii::createObject(UserProfile::className());
        $profile->setAttributes([
            'name' => $this->name,
            'profile_type_id' => $this->profile_type_id,
            'tel_address' => $this->tel_address,
            'cell_id' => $this->cell_id,
        ]);
        $profile->save();

        //save user if there is no other person with that user profile id
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
        
        // saving to partners table a subdealer with her/his fmcgs
        if($this->profile_type_id == Yii::$app->params['SUBDEALER'])
        {
            Partners::savePartners($this->from_id, $profile->id);
        }

    }
    
}
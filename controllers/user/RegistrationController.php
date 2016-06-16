<?php

/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/15/16
 * Time: 9:04 PM
 */

namespace app\controllers\user;

use Yii;
use dektrium\user\controllers\RegisterController as BaseRegistrationController;
use app\models\UserProfile;

class RegistrationController extends BaseRegistrationController
{
//    public function actionRegister()
//    {
//        if (!$this->module->enableRegistration) {
//            throw new NotFoundHttpException();
//        }
//
//        /** @var RegistrationForm $model */
//        $model = Yii::createObject(RegistrationForm::className());
//        $event = $this->getFormEvent($model);
//
//        //$this->trigger(self::EVENT_BEFORE_REGISTER, $event);
//
//        $this->performAjaxValidation($model);
//
//        if ($model->load(Yii::$app->request->post()) && $model->register())
//        {
//            //$userProfile = new UserProfile();
////            $userProfile->
//            //$isValid = $this->performAjaxValidation($profile) && $isValid;
//
////            if($isValid)
////            {
////                $model->save(false);
////                $profile->save(false);
////            }
//
//               // $this->trigger(self::EVENT_AFTER_REGISTER, $event);
//
//                return $this->render('/message', [
//                    'title'  => Yii::t('user', 'Your account has been created'),
//                    'module' => $this->module,
//                ]);
//
//        }
//
//        return $this->render('register', [
//            'model'  => $model,
//            'module' => $this->module,
//            //'userProfile' => UserProfile::find()->all()
//        ]);
//    }
}
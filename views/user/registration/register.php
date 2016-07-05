<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use app\models\RegistrationForm;
use app\models\UserProfile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/**
 * @var yii\web\View              $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module      $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?php
                $a= ['2' => 'SUBDEALER', '3' => 'FMCG'];
                echo $form->field($model, 'profile_type_id')->dropDownList($a,['prompt'=>'Select Category']);
                ?>

<!--                <?php
//                echo $form->field($model, 'from_id')->widget(Select2::classname(), [
//                    'data' => RegistrationForm::getFmcgs(),
//                    'options' => ['placeholder' => 'Select 3 FMCGs ...','multiple' => true],
//                    'pluginOptions' => [
//                        'allowClear' => true
//                    ],
//                ])->label('Preferred FMCGs');
//                ?>-->

<!--                <?//= $form->field($model, 'from_id')->textInput() ?>-->
                <?= $form->field($model, 'tel_address')->textInput() ?>

                <?= $form->field($model, 'cell_id')->textInput(['maxlength' => true]) ?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>


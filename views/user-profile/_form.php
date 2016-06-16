<?php

use app\models\RecordHelpers;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profile_type_id')->dropDownList($model->profileTypeList,
        ['prompt' => 'Please Choose One' ]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!-- <?//= $form->field($model, 'user_code')->textInput(['maxlength' => true]) ?> -->
    <?php $model->user_code =  RecordHelpers::generateCodes($model->profile_type_id, $model->name,
                                    Yii::$app->user->identity->id)?>

<!--    <?//= $form->field($model, 'rating')->textInput() ?>-->

    <?= $form->field($model, 'tel_address')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

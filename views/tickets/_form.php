<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tickets-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <!-- no need coz subdea reporting himself   -->
<!--    <?//= $form->field($model, 'subdea_code')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'product_quantity')->textInput() ?>

    <?= $form->field($model, 'response_time_preference')->widget(DatePicker::classname(), [
        'name' => 'response_time_preference',
        'options' => ['placeholder' => 'Select date'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'noticed_at')->widget(DatePicker::classname(), [
        'name' => 'noticed_at',
        'options' => ['placeholder' => 'Select date'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

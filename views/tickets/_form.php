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

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'subdea_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_quantity')->textInput() ?>

    <?= $form->field($model, 'response_time_preference')->textInput() ?>

    <?= $form->field($model, 'noticed_at')->widget(DatePicker::classname(), [
        'name' => 'noticed_at',
        'type' => DatePicker::TYPE_INPUT,
        'value' => new DateTime('now'),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy'
        ]
    ]); ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_subdea')->dropDownList([ 0 => '0', 1 => '1', 2 => '2', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status_fmcg')->dropDownList([ 0 => '0', 1 => '1', 2 => '2', '' => '', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <!--<?//= $form->field($model, 'created_at')->textInput() ?>-->
    <?= $form->field($model, 'created_at')->widget(DatePicker::classname(), [
        'name' => 'created_at',
        'type' => DatePicker::TYPE_INPUT,
        'value' => new DateTime('now'),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy'
        ]
    ]); ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->widget(DatePicker::classname(), [
        'name' => 'updated_at',
        'type' => DatePicker::TYPE_INPUT,
        'value' => new DateTime('now'),
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy'
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

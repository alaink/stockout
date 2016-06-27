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
    <?php
    $a= ['12' => 'Heineken 33cl','14' => 'Amstel larger', '16' => 'Coka Cola 30cl', '17' => 'Coca Cola - Zero ',
    '19' => 'Fanta Citron', '13' => 'Turbo King']; ?>
<!--    <?//= $form->field($model, 'product_id')->textInput() ?>-->
    <?= $form->field($model, 'product_id')->dropDownList($a, ['id' => 'product-id', 'prompt' => 'Choose a product']); ?>

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

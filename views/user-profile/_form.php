<?php

use app\models\RecordHelpers;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel_address')->textInput() ?>

    <?= $form->field($model, 'district_id')->dropDownList(RecordHelpers::getDistricts(),
        [
            'id'=>'district-id',
            'prompt'=>'Select your District'
        ]) ?>
    
    <?= $form->field($model, 'sector_id')->widget(DepDrop::classname(),
        [
            'options'=>['id'=>'sector-id'],
            'data'=> [$model->sector_id => RecordHelpers::getSectorName($model->sector_id)],
            'pluginOptions'=>[
                'depends'=>['district-id'],
                'placeholder'=>'Select sector...',
                'url'=>Url::to(['/user-profile/sector'])
            ]
        ])?>

    <?= $form->field($model, 'cell_id')->widget(DepDrop::classname(),
        [
            'data'=> [$model->cell_id => RecordHelpers::getCellName($model->cell_id)],
            'pluginOptions'=>[
                'depends'=>['sector-id'],
                'placeholder'=>'Select cell...',
                'url'=>Url::to(['/user-profile/cell'])
            ]
        ])?>

    <?php if(RecordHelpers::getProfileType() == Yii::$app->params['SUBDEALER']): ?>
        <?= $form->field($model, 'from_id')->widget(Select2::classname(), [
            'initValueText' => $model->from_id,
            //'value' => $model->from_id,
            'data' => RecordHelpers::getFmcgs(),
            'options' => ['placeholder' => 'Select FMCGs ...','multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('FMCGs enrolled to');
        ?>
    <?php endif?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

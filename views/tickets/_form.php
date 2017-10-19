<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tickets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($issue_id != Yii::$app->params['OTHER_ISSUE']) { ?>

    <?= $form->field($model, 'sub_issue')->dropDownList($sub_issues,
                                            ['id' => 'sub-issue',
                                                'prompt' => 'Select sub issue',
                                            ]); ?>

    <?php

        // @todo give another option to enter product name or bar code
//    $a= ['12' => 'Heineken 33cl','14' => 'Amstel larger', '16' => 'Coka Cola 30cl', '17' => 'Coca Cola - Zero ',
//    '19' => 'Fanta Citron', '13' => 'Turbo King']; ?>

        <!--<?////= $form->field($model, 'product_id')->textInput() ?>-->
        <!--<?//= $form->field($model, 'product_id')->dropDownList($a, ['id' => 'product-id', 'prompt' => 'Choose a product']); ?>    -->

    <?php
        echo $form->field($products, 'bar_code')->label('Product')
                                                ->widget(Typeahead::classname(), [
                                                        'options' => ['placeholder' => 'Enter bar code ...'],
                                                        'pluginOptions' => ['highlight'=>true],
                                                        'dataset' => [
                                                            [
                                                                'local' => $products_bar_code,
                                                                'limit' => 10
                                                            ]
                                                        ]
                                                    ]);

        ?>

    <?php }?> <!-- END IF not other issues-->

    <!--    stock issues-->
    <?php if ($issue_id == Yii::$app->params['STOCK_ISSUE']) {?>

    <?= $form->field($model, 'product_quantity')->textInput() ?>

    <?= $form->field($model, 'response_time_preference')->widget(DatePicker::classname(), [
                                                        'name' => 'response_time_preference',
                                                        'options' => ['placeholder' => 'Select date'],
                                                        'pluginOptions' => [
                                                            'format' => 'yyyy-mm-dd'
                                                        ]
    ]); ?>
    <?php }?> <!-- END IF stock issues-->

    <!--    stock issues-->
    <?php if ($issue_id == Yii::$app->params['PRODUCT_ISSUE']) {?>

    <?= $form->field($model, 'period_delivered')->widget(DatePicker::classname(), [
                                                'name' => 'period_delivered',
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

    <?php }?> <!-- END IF product issues-->

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

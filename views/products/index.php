<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>


<div class="products-form">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Products Upload Form</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row " style="margin-top: 5px; width: 600px; height: 150px">
        <h5 style='margin: auto;display: block;'><b>Excel sheet template</b> </h5>
        <img src="<?= yii\helpers\Url::to('@web/images/product_template.png') ?>" style='margin: auto;display: block;width: 100%;margin-left: 15%'
             alt="<?php echo Yii::$app->name ?>" title="Product template">
    </div>

    <!-- displaying success flash info if set   -->
    <div class="'row">
        <?php if(Yii::$app->session->hasFlash('success')):?>
            <div class="success alert alert-success">
                <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
    </div>

    <div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= '<br /> <br />'?>
            <?= $form->field($model, 'uploadedFile')->label('Upload Products\' file<hr />')->fileInput(['class'=>'btn btn-sm btn-primary']) ?>

            <?= '<br />' ?>

            <button>Submit</button>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
//Yii::$app->clientScript->registerScript(
//    'myHideEffect',
//    '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
//    CClientScript::POS_READY
//);
//?>
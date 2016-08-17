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

            <?= $form->field($productsModel, 'fmcg')->dropDownList($allFMCGs, [
                    'id' => 'fmcg-sel',
                    'prompt' => 'Select FMCG'])->label("FMCG to upload products for:\n (fmcg must be registered!)<hr/>"); ?>

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
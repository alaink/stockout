<?php

use yii\helpers\Html;
use  \yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */

$this->title = 'Resolve Ticket ';// . $tickets->title;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tickets-resolve">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <div>
        <h3><i>Product Name:  <?= $tickets->getProductName(); ?></h3></i>
    </div>

    <?php echo '<br />';?>

    <?= $form->field($model, 'product_delivered')->checkbox() ?>

    <?= $form->field($model, 'product_picked')->checkbox() ?>

    <?= $form->field($model, 'pickup_underway')->checkbox() ?>

    <?= $form->field($model, 'delivery_underway')->checkbox() ?>

    <?= $form->field($model, 'stock_ordered')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send action undertaken' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>


<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tickets */

$this->title = 'Create a Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tickets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'sub_issues' => $sub_issues,
        'issue_id' => $issue_id,
        'products' => $products,
        'products_bar_code' => $products_bar_code,
    ]) ?>

</div>


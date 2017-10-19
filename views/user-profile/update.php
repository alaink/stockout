<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = 'Update ' . $model->name . "'s profile ";
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="user-profile-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<!--</div>-->

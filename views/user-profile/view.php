<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = $model->name . "'s Profile";
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'profileType.name',
            'name',
            //'user_code',
            'rating',
            'tel_address',
            'location',
        ],
    ]) ?>

</div>

<?php

use app\models\RecordHelpers;
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
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
<!--        <?//= Html::a('Delete', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'rating',
            'tel_address',
            'district_id',
            'sector_id',
            [
                'attribute'=>'cell_id',
                'value' =>  RecordHelpers::getCellName($model->cell_id),
            ],
//            [
//                'label'=>'FMCG enrolled to',
//                'value' =>  $myFMCG[0]['name'],
//            ],
        ],
    ]) ?>

    <?php if(RecordHelpers::getProfileType() == Yii::$app->params['SUBDEALER']): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr ><th >FMCG enrolled to</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($myFMCG as $fmcg): ?>
                        <tr><td><?= $fmcg ?></td></tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif;?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \app\models\RecordHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\Tickets */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tickets-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //change button as either in progress or not
        if($currentTicketStatus == Yii::$app->params['IN_PROGRESS_TICKET']) {
            echo Html::a('In progress', ['update', 'id' => $model->id], ['class' => 'btn btn-warning disabled']);
        }elseif ($currentTicketStatus == Yii::$app->params['RESOLVED_TICKET']){
            // nothing to display
        }
        else {
            echo Html::a('Change to >> In Progress', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']);
        }
        ?>

        <?php //display this button only for unresolved tickets
                if($currentTicketStatus == Yii::$app->params['RESOLVED_TICKET']) {
                    echo Html::a('Resolved', ['action-undertaken/resolve', 'id' => $model->id], [
                        'class' => 'btn btn-info disabled']);
                } else {
                    echo Html::a('Resolve', ['action-undertaken/resolve', 'id' => $model->id], [
                        'class' => 'btn btn-success']);
                }
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'user_id',
            'title',
            'product.name',
            //'subdea_code',
            'product_quantity',
            'response_time_preference',
            'noticed_at',
            'comments:ntext',
            'status_subdea',
            'status_fmcg',
            //'created_by',
            //'created_at',
            'updated_by',
            //'updated_at',
        ],
    ]) ?>

</div>

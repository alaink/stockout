<?php

use app\models\RecordHelpers;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \app\models\Tickets;

/* @var $this yii\web\View */
?>
<?php
$a= ['0' => 'New Tickets','1' => 'Viewed Tickets', '2' => 'Pending Tickets', '3' => 'In Progress Tickets',
    '4' => 'Resolved Tickets', '5' => 'Closed Tickets'];

if($ticket_status != null){
    $this->title = $a[$ticket_status];
}else {
    $this->title = "All Tickets";
}
?>

<div class="row">
    <div class="col-lg-12">
        <?php if($profile_type == Yii::$app->params['SUBDEALER']){ ?>
            <!--            <h1 class="page-header">View Tickets by FMCG</h1>-->
        <?php }else { ?>
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        <?php } ?>
    </div>
    <!-- /.col-lg-12 -->
</div>


<?php $form = ActiveForm::begin(['method' => 'get']) ?>
<div class="form-group">

    <!-- create ticket button for subdealer -->
    <?php if ($profile_type == Yii::$app->params['SUBDEALER']): ?>

        <!--        <?//= Html::a('Create a Ticket', ['/tickets/choose'], ['class'=>'btn btn-primary']); ?>-->

        <div class="row">
            <div class="col-lg-3">
                <h3 class="page-header"><?= Html::encode($this->title) ?></h3>
            </div>
        </div>

    <?php endif; ?>

    <!-- <?php //$form = ActiveForm::begin(['method' => 'get']) ?> -->
    <!--<div class="form-group">-->
    <?= $form->field($model, 'status_col')->dropDownList($a, [
        'id' => 'ticket-status',
        'prompt' => 'Filter Tickets'])->label(''); ?>
</div>

<?php ActiveForm::end(); ?>

<?php if ($profile_type == Yii::$app->params['FMCG'] or $message == null): ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id:integer:#',
            'title',
            [
                'attribute'=>'product_id',
                'label' => 'Product',
                'value' => function($model)
                {
                    return RecordHelpers::getProductName($model['product_id']);
                    //return $model['product_id'] ? RecordHelpers::getProductName($model['product_id']) : '- no product -';
                },
            ],
            [
                'attribute'=>'comments',
                'contentOptions'=>['style'=>'max-width: 100px;']
            ],
            //             'comments:ntext',
            'product_quantity',
            [
                'label' => 'Ticket Status',
                'value' => function($model)
                {
                    //@todo Always view tickets by status of fmcg as clients said only fmcg can resolve tickets. Change if clients want otherwise
//                    if(RecordHelpers::getProfileType() == Yii::$app->params['FMCG'])
//                    {
                    return Tickets::printStatus($model['status_fmcg']);
//                    }
//                    else
//                    {
//                        return Tickets::printStatus($model['status_subdea']);
//                    }
                },
            ],
            'response_time_preference:date:Preferred response time',
            // 'created_at',
            // 'period_delivered',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {resolve}',
                'buttons' => [
                    'view' => function ($model, $dataProvider) {
                        return Html::a('',
                            Yii::$app->request->baseUrl .'/tickets/view/?id =' . $dataProvider['id'],
                            [
                                'class' => 'glyphicon glyphicon-eye-open',
                                'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'View'
                            ]);
                    },
                    'update' => function ($model, $dataProvider) {
                        return Html::a('',
                            ['/tickets/update', 'id' => $dataProvider['id']],
                            [
                                'class' => 'glyphicon glyphicon-pencil',
                                'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'To In Progress'
                            ]);
                    },
                    'resolve' => function ($model, $dataProvider) {
                        return Html::a('',
                            ['/action-undertaken/resolve', 'id' => $dataProvider['id']],
                            [
                                'class' => 'glyphicon glyphicon-ok',
                                'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Resolve',
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php else: ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $message ?>
    </div>
<?php endif; ?>

<?php
if($profile_type == Yii::$app->params['FMCG']):
    $this->registerJs(
        '$(document).ready(function(){
       
        $("#ticket-status").change(function(){
            var e = document.getElementById("ticket-status");
            var strSel = e.options[e.selectedIndex].value;
            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/?status=') . '" + strSel;
        });
        
        });', \yii\web\View::POS_READY);
else:
    $this->registerJs(
        '$(document).ready(function(){

        $("#ticket-status").change(function(){
            var e = document.getElementById("ticket-status");
            var strSel = e.options[e.selectedIndex].value;
            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/?fmcgSelected=') . $fmcgSelected . '&status='. '" + strSel;
        });

        });', \yii\web\View::POS_READY);
endif;
?>


<?php

use app\models\RecordHelpers;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \app\models\Tickets;
use yii\widgets\LinkPager;

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
            <h1 class="page-header">View Tickets by FMCG</h1>
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

        <?= $form->field($model, 'fmcg')->dropDownList($myFMCG, [
                                            'id' => 'fmcg-select',
                                            'prompt' => 'Choose FMCG'])->label('Select FMCG'); ?>

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

<!--<?//= GridView::widget([
//    'dataProvider' => $tickets,
//    'columns' => [
//        ['class' => 'yii\grid\SerialColumn'],
//
//        'id',
//        'title',
//        'product_id',
//        'comments',
//        'product_quantity',
//        'status_fmcg',
//        'status_subdea',
//        'response_time_preference',
//        // 'noticed_at',
//
//
//        'status_fmcg',
//        // 'created_by',
//        // 'created_at',
//        // 'updated_by',
//        // 'updated_at',
//
//        ['class' => 'yii\grid\ActionColumn'],
//    ],
//]); ?> -->

<?php if (!empty($tickets)) { ?>
    <table class="table table-striped table-reflow">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Product name</th>
            <th>Comments</th>
            <th>Product Quantity</th>
            <th>Ticket Status</th>
            <th>Preferred response time</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $ticket) : ?>
            <tr>
                <th scope="row"><?php echo $ticket['id']?></th>
                <td><?php echo $ticket['title'] ?></td>
                <td><?php echo RecordHelpers::getProductName($ticket['product_id']) ?></td>
                <td><?php echo $ticket['comments'] ?></td>
                <td><?php echo $ticket['product_quantity'] ?></td>
                <td><?php if($profile_type == Yii::$app->params['FMCG']) {echo Tickets::printStatus($ticket['status_fmcg']);}
                          else { echo Tickets::printStatus($ticket['status_subdea']); } ?></td>
                <td><?php echo $ticket['response_time_preference'] ?></td>
                <td><?php echo Html::a('', ['/tickets/view?id=' . $ticket['id']], ['class'=>'glyphicon glyphicon-eye-open', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'View']) . "        ";
                    echo Html::a('', ['/tickets/update?id=' . $ticket['id']], ['class'=>'glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'To In Progress']) . "        ";
                    echo Html::a('', ['/action-undertaken/resolve?id=' . $ticket['id']], ['class'=>'glyphicon glyphicon-ok', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Resolve']);?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}else{
    echo "No Tickets to display";
};
?>

<?php echo LinkPager::widget(['pagination' => $pages,]); ?>




<?php
$this->registerJs(
    '$(document).ready(function(){
    
        $("#fmcg-select").change(function(){
            var e = document.getElementById("fmcg-select");
            var strSel = e.options[e.selectedIndex].value;
            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/?fmcgSelected=') . '" + strSel;
        });
    
        $("#ticket-status").change(function(){
            var e = document.getElementById("ticket-status");
            var strSel = e.options[e.selectedIndex].value;
            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/?status=') . '" + strSel;
        });
        
        });', \yii\web\View::POS_READY);
?>


<?php

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

<h1><?= Html::encode($this->title) ?></h1>

<!-- create ticket button for subdealer -->
<?php if ($profile_type == Yii::$app->params['SUBDEALER'])
        {
            echo Html::a('Create a Ticket', ['/tickets/choose'], ['class'=>'btn btn-primary']);
        }
?>

<?php $form = ActiveForm::begin([
                        //'type' => ActiveForm::TYPE_INLINE,
                        'method' => 'get']) ?>

<div class="form-group">
    <?= $form->field($model, 'status_col')->dropDownList($a, ['id' => 'ticket-status', 'prompt' => 'Filter Tickets'])->label(false); ?>

</div>

<?php ActiveForm::end(); ?>

<?php if (!empty($tickets)) { ?>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>N.</th>
            <th>Title</th>
            <th>Product name</th>
            <th>Comments</th>
            <th>Product Quantity</th>
<!--            <th>Subdea Code</th>-->
            <th>Status on FMCG</th>
            <th>Status on Subdealer</th>
            <th>Preferred response time</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $ticket) : ?>
            <tr>
                <td><?php echo $ticket->id ?></td>
                <td><?php echo $ticket->title ?></td>
                <td><?php echo $ticket->getProductName() ?></td>
                <td><?php echo $ticket->comments ?></td>
                <td><?php echo $ticket->product_quantity ?></td>
<!--                <td>--><?php //echo $ticket->subdea_code ?><!--</td>-->
<!--                <td>--><?php //echo $ticket->status_fmcg ?><!--</td>-->
                <td><?php echo Tickets::printStatus($ticket->status_fmcg) ?></td>
                <td><?php echo Tickets::printStatus($ticket->status_subdea) ?></td>
                <td><?php echo $ticket->response_time_preference ?></td>
                <td><?php echo Html::a('', ['/tickets/view?id=' . $ticket->id], ['class'=>'glyphicon glyphicon-eye-open', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'View']) . "        ";
                          echo Html::a('', ['/tickets/update?id=' . $ticket->id], ['class'=>'glyphicon glyphicon-pencil', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'To In Progress']) . "        ";
                          echo Html::a('', ['/tickets/resolve?id=' . $ticket->id], ['class'=>'glyphicon glyphicon-ok', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Resolve']);?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php
}else{
    echo "No Tickets to display";
}; ?>


<?php
$this->registerJs(
    '$(document).ready(function(){
        $("#ticket-status").change(function(){
            var e = document.getElementById("ticket-status");
            var strSel = e.options[e.selectedIndex].value;
            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/?status=') . '" + strSel;
        });
        });', \yii\web\View::POS_READY);
?>


<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use \app\models\Tickets;

/* @var $this yii\web\View */
?>

<h1>Tickets</h1>

<!-- create ticket button for subdealer -->
<?php if ($profile_type == Yii::$app->params['FMCG'])
        {
            echo Html::a('Create Ticket', ['/tickets/create'], ['class'=>'btn btn-primary']);
        }
?>


<?php $form = ActiveForm::begin([
                        //'type' => ActiveForm::TYPE_INLINE,
                        'method' => 'get']) ?>
<div class="form-group">
    <?php $a= ['0' => 'NEW TICKET','1' => 'VIEWED TICKET', '2' => 'PENDING TICKET', '3' => 'IN PROGRESS TICKET',
                '4' => 'RESOLVED TICKET', '5' => 'CLOSED TICKET']; ?>
    <?= $form->field($model, 'status_col')->dropDownList($a, ['id' => 'ticket-status', 'prompt' => 'Choose Tickets']); ?>
</div>
<?php ActiveForm::end(); ?>

<?php if (!empty($tickets)) { ?>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
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
                <td><?php echo $ticket->title ?></td>
                <td><?php echo $ticket->getProductName() ?></td>
                <td><?php echo $ticket->comments ?></td>
                <td><?php echo $ticket->product_quantity ?></td>
<!--                <td>--><?php //echo $ticket->subdea_code ?><!--</td>-->
                <td><?php echo $ticket->status_fmcg ?></td>
                <td><?php echo $ticket->status_subdea ?></td>
                <td><?php echo $ticket->response_time_preference ?></td>
                <td><?php echo Html::a('', ['/tickets/view?id=' . $ticket->id], ['class'=>'glyphicon glyphicon-eye-open']) . "        ";
                          echo Html::a('', ['/tickets/update?id=' . $ticket->id], ['class'=>'glyphicon glyphicon-pencil']) . "        ";
                          echo Html::a('', ['/tickets/resolve?id=' . $ticket->id], ['class'=>'glyphicon glyphicon-ok']);?></td>
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


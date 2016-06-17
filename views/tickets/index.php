<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
?>

<h1>Tickets</h1>
<!--<pre>--><?php ////echo $status_col;
//    //        exit(0);
//    print_r($tickets);
//    ?><!--</pre>-->


<?php $form = ActiveForm::begin([
                        //'type' => ActiveForm::TYPE_INLINE,
                        'method' => 'get']) ?>
<div class="form-group">
    <?php $a= ['0' => 'NEW TICKET','1' => 'PENDING TICKET', '2' => 'OLD TICKET', '3' => 'REJECTED TICKET']; ?>
    <?= $form->field($model, 'status_col')->dropDownList($a, ['id' => 'ticket-status', 'prompt' => 'Choose Tickets']); ?>
</div>
<?php ActiveForm::end(); ?>

<?php if (!empty($tickets)) : ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>comments</th>
                <th>subdea_code</th>
                <th>product_quantity</th>
                <th>status_fmcg</th>
                <th>status_subdea</th>

            </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $ticket) : ?>
            <tr>
                <td><?php echo $ticket->comments?></td>
                <td><?php echo $ticket->subdea_code?></td>
                <td><?php echo $ticket->product_quantity?></td>
                <td><?php echo $ticket->status_fmcg?></td>
                <td><?php echo $ticket->status_subdea?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


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

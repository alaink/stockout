<?php
/* @var $this yii\web\View */
?>
<h1>tickets/index</h1>
<?php if (!empty($tickets)) : ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>comments</th>
                <th>subdea_code</th>
                <th>product_quantity</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $ticket) : ?>
            <tr>
                <td><?php echo $ticket->comments?></td>
                <td><?php echo $ticket->subdea_code?></td>
                <td><?php echo $ticket->product_quantity?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
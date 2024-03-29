<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/8/16
 * Time: 3:32 PM
 */

use yii\helpers\Html;

$this->title = 'Validate Subdealers';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>

<div class="'row">
    <?php if(Yii::$app->session->hasFlash('success')):?>
        <div class="success alert alert-success">
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
</div>

<?php if ($subdealers != null): ?>
    <table class="table table-striped table-reflow">
    <thead>
    <tr>
        <th>Subdealer</th>
        <th>Telephone #</th>
        <th>District : Sector</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($subdealers as $subdealer) : ?>
        <tr>
            <th scope="row"><?php echo $subdealer['name'] ?></th>
            <td><?php echo $subdealer['phone'] ?></td>
            <td><?php echo $subdealer['location'] ; ?></td>
            <td><?php echo Html::a('', ['/validate/confirm?id=' . $subdealer['id']],
                                    ['class'=>'glyphicon glyphicon-thumbs-up', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Validate']) . "              ";
                echo Html::a('', ['/validate/reject?id=' . $subdealer['id']],
                                    ['class'=>'glyphicon glyphicon-thumbs-down', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Reject']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No subdealers to validate!
    </div>
<?php endif;?>



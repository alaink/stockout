<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/8/16
 * Time: 3:32 PM
 */

use app\models\RecordHelpers;
use yii\helpers\Html;

$this->title = 'Validate Subdealers';

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>

<table class="table table-striped table-reflow">
    <thead>
    <tr>
        <th>Subdealer</th>
        <th>Telephone #</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($subdealers as $subdealer) : ?>
        <tr>
            <?php $profile = RecordHelpers::getProfile($subdealer->to_id)?>
            <th scope="row"><?php echo $profile['name'] ?></th>
            <th><?php echo $profile['tel_address'] ?></th>
            <td><?php echo Html::a('', ['/validate/confirm?id=' . $subdealer->to_id], ['class'=>'glyphicon glyphicon-thumbs-up', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Confirm']) . "              ";
                echo Html::a('', ['/validate/reject?id=' . $subdealer->to_id], ['class'=>'glyphicon glyphicon-thumbs-down', 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Reject']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>



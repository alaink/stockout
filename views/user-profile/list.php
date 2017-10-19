<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 8/17/16
 * Time: 6:15 PM
 */
use yii\bootstrap\Html;

$this->title = 'FMCGs registered';
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>

<table class="table table-striped table-reflow">
    <thead>
        <tr>
            <th>FMCG</th>
            <th>Telephone #.</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allFMCGs as $fmcgR) : ?>
            <tr>
                <td> <?= $fmcgR['name']; ?> </td>
                <td> <?= $fmcgR['tel_address']; ?> </td>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
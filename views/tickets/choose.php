<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/28/16
 * Time: 9:27 AM
 */

use app\models\Issue;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \yii\helpers\Url;


$this->title = 'Select an issue';
?>

<?php $form = ActiveForm::begin(); ?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $form->field($model, 'issue')->dropDownList(
                            ArrayHelper::map(Issue::find()->all(), 'issue_id', 'name'),
                            [
                                'id' => 'issue-field',
                                'prompt' => 'Select issue',
                            ]); ?>

<?php
$this->registerJs(
    '$(document).ready(function(){
        $("#issue-field").change(function(){
            var e = document.getElementById("issue-field");
            var strSel = e.options[e.selectedIndex].value;
            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/create/?id=') . '" + strSel;
        });
        });', \yii\web\View::POS_READY);
?>
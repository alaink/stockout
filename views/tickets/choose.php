<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/28/16
 * Time: 9:27 AM
 */

use app\models\Issue;
use app\models\SubIssue;
use kartik\depdrop\DepDrop;
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
                                'onchange' => $this->registerJs('
                                     $("#issue-field").change(function(){
                                        $.post( "'. Yii::$app->urlManager->createUrl('tickets/choose/?id=') .'"+$(this).val(), function (data) {
                                            $("select#sub-issue-field" ). html(data);
                                        });
                                     });
                                ')
                            ]); ?>


<?= $form->field($model, 'sub_issue')->dropDownList(
                            ArrayHelper::map(SubIssue::find()->all(), 'sub_issue_id', 'name'),
                            [
                                'id' => 'sub-issue-field',
                                'prompt' => 'Select sub-issue',
                            ]); ?>


<!--
<?php
//$this->registerJs(
//    '$(document).ready(function(){
//        $("#issue-field").change(function(){
//            var e = document.getElementById("issue-field");
//            var strSel = e.options[e.selectedIndex].value;
//            window.location.href="' . Yii::$app->urlManager->createUrl('tickets/lists/?id=') . '" + strSel;
//        });
//        });');
//?>
-->


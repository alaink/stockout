<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use app\models\RecordHelpers;
use app\models\RegistrationForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

/**
 * @var yii\web\View              $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\Module      $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row col-md-4 col-md-offset-4" style="margin-top: 5px; width: 500px">
    <img src="<?= yii\helpers\Url::to('@web/images/stocout_essai.png') ?>" style='margin: auto;display: block;width: 50%;margin-left: 20%; margin-bottom: 5px;'
         alt="<?php echo Yii::$app->name ?>" title="<?php echo Yii::$app->name ?>">
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>

            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email')->label(false)->textInput(array('placeholder' => 'Email')); ?>

                <?= $form->field($model, 'username')->label(false)->textInput(array('placeholder' => 'Username')); ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput(); ?>
                <?php endif ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false)->textInput(array('placeholder' => 'Name')); ?>

                <?php
                $a= ['2' => 'SUBDEALER', '3' => 'FMCG'];
                echo $form->field($model, 'profile_type_id')->dropDownList($a,['id' => 'profileType','prompt'=>'Select Profile Type'])->label(false);
                ?>

                <div id="preferredFmcg" style="display: none">
                    <?php
                    echo $form->field($model, 'from_id')->widget(Select2::classname(), [

                        'data' => RecordHelpers::getFmcgs(),
                        'options' => ['placeholder' => 'Select FMCGs ...','multiple' => true],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Preferred FMCGs');
                    ?>
                </div>


                <?= $form->field($model, 'tel_address')->label(false)->textInput(array('placeholder' => 'Telephone Number'));  ?>

                <?= $form->field($model, 'district_id')->dropDownList(RecordHelpers::getDistricts(),
                                                        [
                                                            'id'=>'district-id',
                                                            'prompt'=>'Select your District'
                                                        ])->label(false) ?>

                <?= $form->field($model, 'sector_id')->widget(DepDrop::classname(),
                                                        [
                                                            'options'=>['id'=>'sector-id'],
                                                            'pluginOptions'=>[
                                                                'depends'=>['district-id'],
                                                                'placeholder'=>'Select sector...',
                                                                'url'=>Url::to(['/user-profile/sector'])
                                                            ]
                                                        ])->label(false)?>

                <?= $form->field($model, 'cell_id')->widget(DepDrop::classname(),
                                                        [
                                                            'pluginOptions'=>[
                                                                'depends'=>['sector-id'],
                                                                'placeholder'=>'Select cell...',
                                                                'url'=>Url::to(['/user-profile/cell'])
                                                            ]
                                                        ])->label(false)?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>

<?php
$this->registerJs(
"document.onreadystatechange = function () {
     if (document.readyState === 'interactive') {
          var droplist = $('#profileType');
          droplist.change(function(e){
            if (droplist.val() == 2) {
              $('#preferredFmcg').show();
            }else{
                $('#preferredFmcg').hide();
            }
          })
      }
};
", \yii\web\View::POS_HEAD);
?>


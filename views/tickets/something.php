<?php

use kartik\depdrop\DepDrop;
use \yii\helpers\ArrayHelper;
use \app\models\MajorIssue;
?>

<?php

// Parent
//echo $form->field($model, 'major_issue')->dropDownList($catList, ['id'=>'cat-id']);

 Html::activeDropDownList($model, 'major_issue', $major_issues);

// Child # 1
//echo $form->field($model, 'subcat')->widget(DepDrop::classname(), [
//    'options'=>['id'=>'subcat-id'],
//    'pluginOptions'=>[
//        'depends'=>['cat-id'],
//        'placeholder'=>'Select...',
//        'url'=>Url::to(['/site/subcat'])
//    ]
//]);

?>

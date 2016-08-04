<?php

use app\models\RecordHelpers;
use yii\helpers\Html;
use yii\helpers\Url;

$profileType = RecordHelpers::getProfileType();

?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; ">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- <a class="navbar-brand" href=<?php echo Yii::$app->getHomeUrl() ?>><?= Yii::$app->name?></a> -->
        <a class="brand brand-name navbar-left" href=<?php echo Yii::$app->getHomeUrl() ?>>
            <!--<?= Html::img('@web/images/stocout _logo_final.png', ['alt'=>'some', 'class'=>'thing',  'style'=>"max-width: 15%; max-height: 15%;"]);?></a>-->
            <img src="<?= yii\helpers\Url::to('@web/images/stocout_essai.png') ?>" style='margin-top: -5px; width: 128px;'
                alt="<?php echo Yii::$app->name ?>" title="<?php echo Yii::$app->name ?>"></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right" style='margin-top: 20px;'>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i><?= Yii::$app->user->identity->username ?>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo Url::to(['/user-profile/view']) ?> "><i class="fa fa-user fa-fw"></i> Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo Url::to(['/site/logout']) ?> " data-method="post"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation" style='margin-top: 90px '>
        <div class="sidebar-nav navbar-collapse " >
            <ul class="nav" id="side-menu" >

                <?php if ($profileType == Yii::$app->params['FMCG']): ?>
                <li>
                    <a href=<?php echo Yii::$app->getHomeUrl() ?>><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <?php endif; ?>

                <li>
                    <a href=<?php echo Yii::$app->urlManager->createUrl(['tickets/'])?> >
                        <i class="fa fa-dashboard fa-fw"></i> Tickets</a>
                </li>

                <?php if ($profileType == Yii::$app->params['FMCG']){ ?>

                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['validate/'])?> >
                            <i class="fa fa-dashboard fa-fw"></i> Validate subdealers</a>
                    </li>
                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['products/'])?> >
                            <i class="fa fa-dashboard fa-fw"></i> Upload more products</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
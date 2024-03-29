<?php

use app\models\RecordHelpers;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$profileType = RecordHelpers::getProfileType();

?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0px; ">
    <div class="navbar-header">
        <a class="brand brand-name navbar-left" href=<?php echo Yii::$app->getHomeUrl() ?>>
            <!--<?= Html::img('@web/images/stocout _logo_final.png', ['alt'=>'some', 'class'=>'thing',  'style'=>"max-width: 15%; max-height: 15%;"]);?></a>-->
            <img src="<?= yii\helpers\Url::to('@web/images/stocOut_LOGO_finalist.png') ?>" style='margin-top: 0.5px; width: 143px;'
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

                <?php if ($profileType == Yii::$app->params['FMCG'] or $profileType == Yii::$app->params['SUBDEALER']): ?>
                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['tickets/'])?> >
                            <i class="fa fa-dashboard fa-fw"></i> Tickets</a>
                    </li>
                <?php endif; ?>

                <?php if ($profileType == Yii::$app->params['SUBDEALER']): ?>
                    <?php
                    $myFMCG = RecordHelpers::getMyFmcgs();
                    foreach ($myFMCG as $key => $fmcg):
                        ?>
                        <li style="margin-left: 8%">
                            <a href=<?php echo Yii::$app->urlManager->createUrl(['tickets/index', 'fmcgSelected' => $key])?> >
                                <i class="fa fa-building-o fa-fw"></i> <?= $fmcg?></a>
                        </li>
                    <?php endforeach;?>
                <?php endif; ?>

                <?php if ($profileType == Yii::$app->params['FMCG']){ ?>

                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['validate/'])?> >
                            <i class="fa fa-dashboard fa-fw"></i> Validate subdealers</a>
                    </li>
                <?php } ?>

                <?php if (User::isUserAdmin(Yii::$app->user->identity->username)){ ?>

                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['products/'])?> >
                            <i class="fa fa-dashboard fa-fw"></i> Upload more products</a>
                    </li>

                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['user-profile/list'])?> >
                            <i class="	fa fa-users"></i> FMCGs registered</a>
                    </li>
                <?php } ?>

                <li>
                    <a href="<?php echo Url::to(['/user-profile/view']) ?> "><i class="fa fa-user fa-fw"></i> Profile</a>
                </li>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>

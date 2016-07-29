<?php

use app\models\RecordHelpers;
use yii\helpers\Url;

?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href=<?php echo Yii::$app->getHomeUrl() ?>><?= Yii::$app->name?></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
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

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href=<?php echo Yii::$app->getHomeUrl() ?>><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <!-- TICKETS-->
                <li>
                    <a href=<?php echo Yii::$app->urlManager->createUrl(['tickets/'])?> >
                        <i class="fa fa-dashboard fa-fw"></i> Tickets</a>
                </li>

                <?php if (RecordHelpers::getProfileType() == Yii::$app->params['FMCG']){ ?>

                    <!-- VALIDATE SUBDEALER-->
                    <li>
                        <a href=<?php echo Yii::$app->urlManager->createUrl(['validate/'])?> >
                            <i class="fa fa-dashboard fa-fw"></i> Validate subdealers</a>
                    </li>

                    <!-- UPLOAD PRODUCTS FILE -->
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
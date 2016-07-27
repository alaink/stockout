<?php

use app\models\ChartHelper;
use app\models\ChartHelpers;
use app\models\RecordHelpers;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Stock Out';
?>

    <div class="container-fluid">
        <?php if((!Yii::$app->user->isGuest )): ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <?php if(RecordHelpers::getProfileType() == 3) :?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Retailers by Region / Map</b>
                        </div>
                        <div id="carte" class="panel-body" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">
                            <?= Html::img('@web/images/carte.png', ['alt'=>'some', 'class'=>'thing',  'style'=>"max-width: 100%; max-height: 100%;"]);?>
                        </div> <!-- panel body-->
                    </div> <!-- panel default-->

                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Tickets by product</b>
                        </div>
                        <?php if ($ticketByProductChart != 'no data'): ?>
                            <div id="ticket_product" class="panel-body" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            <?php $this->registerJs($ticketByProductChart, \yii\web\View::POS_END);?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                No data
                            </div>
                        <?php endif;?>
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Retailers by Region / Chart </b>
                        </div>
                        <div id="retailer-region" class="panel-body" style="min-width: 300px; height: 400px; margin: 0 auto">

                        </div> <!-- panel body-->
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12" >
                    <div class="panel panel-default span4 offset4">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw" ></i><b> Tickets by Type</b>
                        </div>
                        <?php if ($ticketByTypeChart != 'no data'): ?>
                            <div id="ticket_type" class="panel-body" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> <!-- panel body-->
                            <?php $this->registerJs($ticketByTypeChart, \yii\web\View::POS_END);?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                No data
                            </div>
                        <?php endif;?>
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Status of tickets by region</b>
                        </div>
                        <div id="status-ticket-region" class="panel-body" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto">
                        </div> <!-- panel body-->
                        <?php $this->registerJs($statusTicketByRegionChart, \yii\web\View::POS_END);?>
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Weekly Ticket - Stacked</b>
                        </div>
                        <?php if ($weeklyTicketStackedChart != 'no data'): ?>
                            <div id="weekly-ticket-stacked" class="panel-body" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div> <!-- panel body-->
                            <?php $this->registerJs($weeklyTicketStackedChart, \yii\web\View::POS_END);?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                No data
                            </div>
                        <?php endif;?>
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Weekly Ticket - Basic line</b>
                        </div>
                        <?php if ($weeklyTicketStackedChart != 'no data'): ?>
                            <div id="weekly-ticket-basic-line" class="panel-body" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto"></div> <!-- panel body-->
                            <?php $this->registerJs($weeklyTicketLineChart, \yii\web\View::POS_END);?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                No data
                            </div>
                        <?php endif;?>
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->
        <?php endif;?>

        <?php endif;?> <!-- checking guest-->
    </div>
    <!-- /.container-fluid -->

    <!-- RETAILER BY REGION CHART-->
<?php
$this->registerJs('
    $(function () {
    $(\'#retailer-region\').highcharts({
        chart: {
            type: \'column\'
        },
        title: {
            text: \'\'
        },
        xAxis: {
            type: \'category\',
            labels: {
                rotation: -45,
                style: {
                    fontSize: \'10px\',
                    fontFamily: \'Verdana, sans-serif\'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: \'Retailers (hundreds)\'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: \'Retailers in 2016: <b>{point.y:.1f} hundreds</b>\'
        },
        series: [{
            name: \'District\',
            data: [
                [\'Gasabo\', 23.7],
                [\'Kicukiro\', 19.7],
                [\'Ngoma\', 16.1],
                [\'Nyarugenge\', 20.1],
                [\'Rubavu\', 18.1],
                [\'Kayonza\', 14.2],
                [\'Rulindo\', 14.0],
                [\'Kirehe\', 12.5],
                [\'Nyamagabe\', 9.1],
                [\'Muhanga\', 8.8],
                [\'Karongi\', 7.7],
                [\'Ruhango\', 7.1],
                [\'Huye\', 6.1],
                [\'Gisagara\', 5.5],
                [\'Bugesera\', 4.4],
                [\'Musanze\', 3.0],
                [\'Rusizi\', 2.3],
                [\'Nyabihu\', 1.3],
                [\'Nyamagabe\', 0],
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: \'#FFFFFF\',
                align: \'right\',
                format: \'{point.y:.1f}\', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: \'13px\',
                    fontFamily: \'Verdana, sans-serif\'
                }
            }
        }],
        credits: {
              enabled: false
            },
    });
});
');
?>


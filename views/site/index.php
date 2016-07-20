<?php

use app\models\ChartHelper;
use app\models\ChartHelpers;
use app\models\RecordHelpers;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Stock Out';
$ticket_by_product = ChartHelpers::getProductOccurrence();
$ticket_by_type = ChartHelpers::getTicketsByType();

?>

    <div class="container-fluid">

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
                        <div id="ticket_product" class="panel-body" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">

                        </div> <!-- panel body-->
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
                        <div id="ticket_type" class="panel-body" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto">

                        </div> <!-- panel body-->
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
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Weekly Ticket - Stacked</b>
                        </div>
                        <div id="weekly-ticket-stacked" class="panel-body" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto">

                        </div> <!-- panel body-->
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i><b> Weekly Ticket - Basic line</b>
                        </div>
                        <div id="weekly-ticket-basic-line" class="panel-body" style="min-width: 310px; height: 400px; max-width: 100%; margin: 0 auto">

                        </div> <!-- panel body-->
                    </div> <!-- panel default-->

                </div>
            </div> <!-- row -->
        <?php endif;?>

    </div>
    <!-- /.container-fluid -->

    <!-- TICKET BY PRODUCT CHART-->
<?php
$this->registerJs('

$(function () {
    $(\'#ticket_product\').highcharts({
        chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: \'pie\'
            },
            title: {
                text: \'\'
            },
            tooltip: {
                pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
            },
            legend: {
                labelFormat: \'{name} - {percentage:.1f}%\',
                layout: \'vertical\',
                align: \'right\',
                verticalAlign: \'middle\',
                borderWidth: 0
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: \'pointer\',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: \'Brands\',
                colorByPoint: true,
                data: ' . $ticket_by_product . ',
                dataLabels: {
                    //enabled: true
                }
            }],
            credits: {
              enabled: false
            },
    });
});
');
?>

    <!-- TICKET BY TYPE CHART-->
<?php
$this->registerJs('

$(function () {
    $(\'#ticket_type\').highcharts({
        chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: \'pie\'
            },
            title: {
                text: \'\'
            },
            tooltip: {
                pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
            },
            legend: {
                labelFormat: \'{name} - {percentage:.1f}%\',
                layout: \'vertical\',
                align: \'right\',
                verticalAlign: \'middle\',
                borderWidth: 0
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: \'pointer\',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: \'Brands\',
                colorByPoint: true,
                data: ' . $ticket_by_type . '
            }],
            credits: {
              enabled: false
            },
    });
});
');
?>

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

    <!-- STATUS OF TICKET BY REGION CHART-->
<?php
$this->registerJs('
    $(function () {
    $(\'#status-ticket-region\').highcharts({
        chart: {
            type: \'column\'
        },
        title: {
            text: \'\'
        },
        xAxis: {
            categories: 
                        [
                        \'Nyarugenge\', \'Gasabo\',\'Kicukiro\',\'Nyanza\',\'Gisagara\',\'Nyaruguru\',
                        \'Huye\',\'Nyamagabe\',\'Ruhango\',\'Muhanga\',\'Kamonyi\',\'Karongi\',
                        \'Rutsiro\',\'Rubavu\',\'Nyabihu\',\'Ngororero\',\'Rusizi\',\'Nyamasheke\',
                        \'Rulindo\',\'Gakenke\',\'Musanze\',\'Burera\',\'Gicumbi\',\'Rwamagana\',
                        \'Nyagatare\',\'Gatsibo\',\'Kayonza\',\'Kirehe\',\'Ngoma\',\'Bugesera\'
                        ],
            labels: {
                rotation: -45,
                style: {
                    fontSize: \'10px\',
                    fontFamily: \'Verdana, sans-serif\'
                }
            },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: \'Tickets\'
            }
        },
        tooltip: {
            headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
            pointFormat: \'<tr><td style="color:{series.color};padding:0">{series.name}: </td>\' +
                \'<td style="padding:0"><b>{point.y:.0f} </b></td></tr>\',
            footerFormat: \'</table>\',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: ' . ChartHelpers::statusTicketsByRegionData() . ',
        credits: {
              enabled: false
            },
    });
});
');
?>

    <!-- WEEKLY TICKET - STACKED CHART-->
<?php
$this->registerJs('
    $(function () {
    $(\'#weekly-ticket-stacked\').highcharts({
        chart: {
            type: \'column\'
        },
        title: {
            text: \'\'
        },
        xAxis: {
            categories: [' . join(ChartHelpers::formatWeeks(), ",") . '],
            title: {
                text: \'Weeks\'
            },
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
                text: \'Issues\'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: \'bold\',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || \'gray\'
                }
            }
        },
        legend: {
            align: \'right\',
            x: -30,
            verticalAlign: \'top\',
            y: 5,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || \'white\',
            borderColor: \'#CCC\',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: \'<b>{point.x}</b><br/>\',
            pointFormat: \'{series.name}: {point.y}<br/>Total: {point.stackTotal}\'
        },
        plotOptions: {
            column: {
                stacking: \'normal\',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || \'white\',
                    style: {
                        textShadow: \'0 0 3px black\'
                    }
                }
            }
        },
        series: ' . ChartHelpers::weeklyTicketsByTypeData() . ',
        credits: {
              enabled: false
            },
    });
});
');
?>

    <!-- WEEKLY TICKET - BASIC LINE -->
<?php
$this->registerJs('
    $(function () {
    $(\'#weekly-ticket-basic-line\').highcharts({
        title: {
            text: \'\',
            x: -20 //center
        },
        xAxis: {
            categories: [' . join(ChartHelpers::formatWeeks(), ",") . '],
            title: {
                text: \'Weeks\'
            },
            labels: {
                rotation: -45,
                style: {
                    fontSize: \'10px\',
                    fontFamily: \'Verdana, sans-serif\'
                }
            }
        },
        yAxis: {
            title: {
                text: \'Issues\'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: \'#808080\'
            }]
        },
        tooltip: {
            valueSuffix: \'\'
        },
        legend: {
            layout: \'vertical\',
            align: \'right\',
            verticalAlign: \'middle\',
            borderWidth: 0
        },
        series: ' . ChartHelpers::weeklyTicketsByTypeData() . ',
        credits: {
              enabled: false
            },
    });
});
');
?>
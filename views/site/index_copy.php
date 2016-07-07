<?php

use app\models\RecordHelpers;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;

/* @var $this yii\web\View */

$this->title = 'Stock Out';
$data = RecordHelpers::getProductOccurrence();
RecordHelpers::getProductOccurrence();
?>

<!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Tickets by product
                </div>
                <div class="panel-body">
                    <?php
                    echo Highcharts::widget([
                        'scripts' => [
                            //'modules/exporting',
                            'themes/grid-light',
                        ],
                        'options' => [
                            'chart'=> [
                                'plotBackgroundColor'=> null,
                                'plotBorderWidth'=> null,
                                'plotShadow'=> false,
                                'type'=> 'pie'
                            ],
//                            'title'=> [
//                                'text'=> 'Browser market shares January, 2015 to May, 2015'
//                            ],
                            'tooltip'=> [
                                'pointFormat'=> '{series.name}: <b>{point.percentage:.1f}%</b>'
                            ],
                            'plotOptions'=> [
                                'pie'=> [
                                    'allowPointSelect'=> true,
                                    'cursor'=> 'pointer',
                                    'dataLabels'=> [
                                        'enabled'=> false
                                    ],
                                    'showInLegend'=> true
                                ]
                            ],
                            'series'=> [[
                                'name'=> 'Brands',
                                'colorByPoint'=> true,
                                'data'=> new SeriesDataHelper($data, ['name', 'y']),

//                                    [
//                                    [
//                                    'name'=> 'Microsoft Internet Explorer',
//                                    'y'=> 56.33
//                                ], [
//                                    'name'=> 'Chrome',
//                                    'y'=> 24.03,
//                                    'sliced'=> true,
//                                    'selected'=> true
//                                ], [
//                                    'name'=> 'Firefox',
//                                    'y'=> 10.38
//                                ], [
//                                    'name'=> 'Safari',
//                                    'y'=> 4.77
//                                ], [
//                                    'name'=> 'Opera',
//                                    'y'=> 0.91
//                                ], [
//                                    'name'=> 'Proprietary or Undetectable',
//                                    'y'=> 0.2
//                                ]],
                            ]],
                        ]
                    ]);
                    ?>
                </div> <!-- panel body-->
            </div> <!-- panel default-->

        </div>
    </div>

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Most active subdealers
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Action</a>
                                </li>
                                <li><a href="#">Another action</a>
                                </li>
                                <li><a href="#">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>3326</td>
                                        <td>10/21/2013</td>
                                        <td>3:29 PM</td>
                                        <td>$321.33</td>
                                    </tr>
                                    <tr>
                                        <td>3325</td>
                                        <td>10/21/2013</td>
                                        <td>3:20 PM</td>
                                        <td>$234.34</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.col-lg-4 (nested) -->
                        <div class="col-lg-8">
                            <div id="morris-bar-chart"></div>
                        </div>
                        <!-- /.col-lg-8 (nested) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-clock-o fa-fw"></i> Responsive Timeline
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-badge"><i class="fa fa-check"></i>
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="timeline-title">Lorem ipsum dolor</h4>
                                    <p><small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via Twitter</small>
                                    </p>
                                </div>
                                <div class="timeline-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero laboriosam dolor perspiciatis omnis exercitationem. Beatae, officia pariatur? Est cum veniam excepturi. Maiores praesentium, porro voluptas suscipit facere rem dicta, debitis.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i> Tickets Evolvement
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body" id="tickets-evolvement" style="min-width: 330px; height: 250px; max-width:600px; margin: 0 auto">
                    <!--                    <div class="list-group">-->
                    <!--                        <h4>New Tickets</h4>-->
                    <!--                        <h4>Viewed Tickets</h4>-->
                    <!--                        <h4>Pending Tickets</h4>-->
                    <!--                        <a href="#" class="list-group-item">-->
                    <!--                            <i class="fa fa-bolt fa-fw"></i> Server Crashed!-->
                    <!--                                    <span class="pull-right text-muted small"><em>11:13 AM</em>-->
                    <!--                                    </span>-->
                    <!--                        </a>-->
                    <!--                    </div>-->
                    <!--                    <!-- /.list-group -->
                    <!--                    <a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
                    <?php
                    echo Highcharts::widget([
                        'options' => [
//                            'title' => ['text' => 'Fruit Consumption'],
//                            'xAxis' => [
//                                'categories' => ['Apples', 'Bananas', 'Oranges']
//                            ],
//                            'yAxis' => [
//                                'title' => ['text' => 'Fruit eaten']
//                            ],
//                            'series' => [
//                                ['name' => 'Jane', 'data' => [1, 0, 4]],
//                                ['name' => 'John', 'data' => [5, 7, 3]]
//                            ]
                            'chart'=> [
                                'type' => 'pie',
                            ],
                            'title'=> [
                                'text'=> 'Tickets Evolvement',
                                'y'=> 5
                            ],
                            'tooltip'=> [
                                'pointFormat'=> '{series.name}: <b>{point.percentage:.1f}%</b>'
                            ],
                            'plotOptions'=> [
                                'pie' => [
                                    'dataLabels'=> [
                                        'enabled'=> true,
                                        'distance'=> -10,
                                        'style'=> [
                                            'fontWeight'=> 'bold',
                                            'color'=> 'white',
                                            'textShadow'=> '0px 1px 2px black'
                                        ]
                                    ],
                                    'size' => 250,
                                    'startAngle'=> -90,
                                    'endAngle'=> 90,
                                    'center'=> ['50%', '35%']
                                ],
                            ],
                            'series'=> [[
                                'type'=> 'pie',
                                'name'=> 'Evolution',
                                'innerSize'=> '50%',
                                'data'=> [
                                    ['New Tickets',   10.38],
                                    ['Viewed Tickets',       56.33],
                                    ['Pending Tickets', 24.03],
                                    ['Resolved Tickets',    4.77],
                                    ['Closed Tickets',     0.91],
                                    [
                                        'name'=> 'Tickets Evolvement',
                                        'y'=> 0.2,
                                        'dataLabels'=> [
                                            'enabled'=> 'false',
                                        ]
                                    ]
                                ]
                            ]],
                            'credits' => ['enabled' => false],
                        ]
                    ]);
                    ?>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->


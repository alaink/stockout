<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/20/16
 * Time: 3:03 PM
 */

namespace app\models;


class DrawCharts
{
    public static function pieChart($data, $container=null)
    {     
        
        $js = [];
        $js[] = "$(function () {
            $('#".$container."').highcharts({
                chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    legend: {
                        labelFormat: '{name} - {percentage:.1f}%',
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Brands',
                        colorByPoint: true,
                        data: " . $data . ",
                        dataLabels: {
                            //enabled: true
                        }
                    }],
                    credits: {
                      enabled: false
                    },
            });
        });";
        
        
        if($data != '[]'):
            return implode("\n", $js);
        else:
            return 'no data';
        endif;
    }

    public static function basicColumn($data, $container=null)
    {
        $js = [];
        $js[] = "$(function () {
            $('#".$container."').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: 
                                [
                                'Nyarugenge', 'Gasabo','Kicukiro','Nyanza','Gisagara','Nyaruguru',
                                'Huye','Nyamagabe','Ruhango','Muhanga','Kamonyi','Karongi',
                                'Rutsiro','Rubavu','Nyabihu','Ngororero','Rusizi','Nyamasheke',
                                'Rulindo','Gakenke','Musanze','Burera','Gicumbi','Rwamagana',
                                'Nyagatare','Gatsibo','Kayonza','Kirehe','Ngoma','Bugesera'
                                ],
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '10px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    },
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Tickets'
                    }
                },
                tooltip: {
                    headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
                    pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
                        '<td style=\"padding:0\"><b>{point.y:.0f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: " . $data . ",
                credits: {
                      enabled: false
                    },
            });
        });";

        return implode("\n", $js);
    }

    public static function stackedColumn($period, $data, $container=null)
    {
        $js = [];
        $js[] = "$(function () {
            $('#".$container."').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: [" . $period . "],
                    title: {
                        text: 'Weeks'
                    },
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '10px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Issues'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 5,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: false,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                            style: {
                                textShadow: '0 0 3px black'
                            }
                        }
                    }
                },
                series: " . $data . ",
                credits: {
                      enabled: false
                    },
            });
        });";

        $decodedData = json_decode($data, true);
        if($decodedData[0]['data'] != null and $decodedData[1]['data'] != null and $decodedData[2]['data'] != null):
            return implode("\n", $js);
        else:
            return 'no data';
        endif;
    }

    public static function basicLine($period, $data, $container=null)
    {
        $js = [];
        $js[] = "$(function () {
            $('#".$container."').highcharts({
                title: {
                    text: '',
                    x: -20 //center
                },
                xAxis: {
                    categories: [" . $period . "],
                    title: {
                        text: 'Weeks'
                    },
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '10px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Issues'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ''
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: " . $data . ",
                credits: {
                      enabled: false
                    },
            });
        });";

        return implode("\n", $js);
    }

    public static function rotatedLColumn($data, $container=null)
    {
        $js = [];
        $js[] = "$(function () {
            $('#".$container."').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '10px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Retailers (hundreds)'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Retailers in 2016: <b>{point.y:.1f} hundreds</b>'
                },
                series: [{
                    name: 'District',
                    data: [
                        " . $data . "
                    ],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:.0f}', // one decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }],
                credits: {
                      enabled: false
                    },
            });
        });";

        return implode("\n", $js);
    }

}
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
        
        
//        if($data[0] !='' || $data[1] !=''):
            return implode("\n", $js);
//        else:
//            return 'no data';
//        endif;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 7/7/16
 * Time: 10:14 AM
 */

namespace app\models;


class ChartHelper
{
    public static function displayChart($data, $container)
    {
        //$data = explode(';', $data);

        $js = [];

        $js[] = '

$(function () {
    $(#' . $container . ').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: \'pie\'
        },
        title: {
            text: \'Browser market shares January, 2015 to May, 2015\'
        },
        tooltip: {
            pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: \'pointer\',
                dataLabels: {
                    enabled: true,
                    format: \'<b>{point.name}</b>: {point.percentage:.1f} %\',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || \'black\'
                    }
                }
            }
        },
        series: [{
            name: \'Brands\',
            colorByPoint: true,
            data: ' . $data . '

        }]
    });
});

';

        return implode("\n", $js);
    }
}
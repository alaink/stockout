<?php
/**
 * Created by PhpStorm.
 * User:
 * Date: 24/03/2016
 * Time: 12:28
 */

namespace app\assets;


use yii\web\AssetBundle;

class HighChartsAsset  extends AssetBundle{

    public $sourcePath = '@app/theme/highChart';
    public $basePath = '@app';

    public $publishOptions = [
        'forceCopy' => true,
    ];

    public $css = [];

    public $js = [
        'highcharts.js',
        'exporting.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];

}
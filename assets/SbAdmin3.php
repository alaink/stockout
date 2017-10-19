<?php
/**
 * Created by PhpStorm.
 * User: aakuzwe
 * Date: 6/3/16
 * Time: 10:37 AM
 */

namespace app\assets;

use yii\web\AssetBundle;

class SbAdmin3 extends AssetBundle
{
    public $sourcePath = '@app/theme/sbAdmin';
    public $basePath = '@app';
    public $css = [
    'css/sb-admin-2.css', 
    'font-awesome/css/font-awesome.min.css',
    ];
    public $js = [
//    'js/sbAdmin.js',
//    'js/metisMenu.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'

    ];
}
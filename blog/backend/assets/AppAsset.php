<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/mui.min.css',
        'css/iconfont.css',
        'css/ace.min.css',
        'css/font-awesome.min.css',
        'css/index.css',
    ];
    public $js = [
    	'js/app/angular.js',
    	'js/app/common.js',
    	'js/directives/selectRow.js',
    	'js/app/app.js',
		
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

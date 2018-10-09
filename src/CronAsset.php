<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mirocow\cron;

use Yii;
use yii\web\AssetBundle;

/**
 * Class CronAsset
 * @package mirocow\cron
 */
class CronAsset extends AssetBundle
{

    public $baseUrl = '@web';
    public $sourcePath = '@mirocow/cron/assets';
    public $css = [
        'jquery-cron.css',
    ];

    public $js = [
        'jquery-cron.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
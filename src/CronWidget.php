<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mirocow\cron;

use Yii;
yii\widgets\InputWidget; 
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Class CronWidget
 * @package mirocow\cron
 */
class CronWidget extends InputWidget
{
    /** @var string */
    public static $componentId = 'cron-widget';

    /** @var string */
    public $tagName = 'div';

    /** @var string */
    public $tagInputName = 'shedule';

    /** @var array */
    public $htmlOptions = array(
        'class' => 'cron-widget',
    );

    /** @var string  */
    public $initial = '42 3 * * 5';

    /** @var array  */
    public $customValues = 'undefined';

    /**
     * Run widget.
     */
    public function run() {
        parent::run();
        echo Html::tag($this->tagName, '', $this->htmlOptions);
        echo Html::hiddenInput($this->tagInputName, $this->initial);
        $this->registerAssets();
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        CronAsset::register($view);
        $js =<<<JS
        $('{$this->componentId}').cron({
            initial: "{$this->initial}",
            onChange: function() {
                $('{$this->tagInputName}').text($(this).cron("value"));
            },
            customValues: {$this->customValues()}   
        });
JS;
        $view->registerJs($js);
    }

    protected function customValues()
    {
        if(is_array($this->customValues)){
            return json_encode($this->customValues, JSON_FORCE_OBJECT);
        }

        return $this->customValues;
    }

}

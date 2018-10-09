<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace mirocow\cron;

use Yii;
use yii\widgets\InputWidget; 
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
    public $tagName = 'div';

    /** @var string */
    public $tagInputName = 'shedule';

    /** @var array */
    public $htmlOptions = array(
        'class' => 'cron-widget',
    );

    /** @var string  */
    public $value = '* * * * *';

    /** @var array  */
    public $customValues = 'undefined';

    /**
     * Run widget.
     */
    public function run() {
        parent::run();
        $this->htmlOptions['id'] = $this->id;
        Html::addCssClass($this->htmlOptions, 'form-control');
        echo Html::tag($this->tagName, '', $this->htmlOptions);
        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->tagInputName);
        } else {
            echo Html::hiddenInput($this->tagInputName, $this->initial);
        }
        $this->registerAssets();
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        CronAsset::register($view);
        if ($this->hasModel()) {
            $attributeId = Html::getInputId($this->model, $this->tagInputName);
            $value = $this->model->value;
        } else {
            $attributeId = $this->tagInputName;
        }
        if(!$value){
            $value = $this->value;
        }
        $js =<<<JS
        $('#{$this->id}').cron({
            initial: "{$value}",
            onChange: function() {
                $('{$attributeId}').text($(this).cron("value"));
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

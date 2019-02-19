<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets;

use yii\helpers\Url;

/**
 * Class Select
 * @package codexten\yii\web\widgets\select
 * @author Junaid Rahman <junaid.entero@gmail.com>
 * @author Jomon Johnson <jomon@entero.in>
 */
class Select2 extends \kartik\select2\Select2
{
    public $placeholder = '';
    public $initValue = '';
    public $url = false;
    public $data = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->normalize();
        parent::init();
    }

    /**
     * Normalizing configuration
     */
    public function normalize()
    {
        if ($this->placeholder) {
            $this->options['placeholder'] = $this->placeholder;
        }
        if ($this->initValue) {
            $this->initValueText = $this->initValue;
        }

        if ($this->url) {
            $this->pluginOptions['ajax']['url'] = Url::to($this->url);
        }
    }
}
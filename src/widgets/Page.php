<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/10/18
 * Time: 2:29 PM
 */

namespace codexten\yii\web\widgets;

use codexten\yii\web\Widget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Page extends Widget
{
    /**
     * @var string
     */
    public $title;
    /**
     * @var bool|string
     */
    public $subTitle = false;
    /**
     * @var string
     */
    public $icon;
    /**
     * @var array
     */
    public $actions = [];

    public $defaultButtonOptions = [
        'class' => ['btn'],
    ];
    public $defaultButtonDropdownConfig = [
        'options' => ['class' => ['btn']],
    ];

    public function renderButton($text, $url, $options = [])
    {
        $options = ArrayHelper::merge($this->defaultButtonOptions, $options);

        return Html::a($text, $url, $options);
    }

    public function renderButtonDropdown($label, array $items, array $config = [])
    {
        $config = ArrayHelper::merge($this->defaultButtonDropdownConfig, $config);
        $config['label'] = $label;
        $config['dropdown']['items'] = $items;

        return ButtonDropdown::widget($config);
    }

    public function renderSuccessButtonDropdown($label, array $items, array $config = [])
    {
        $config = ArrayHelper::merge([
            'options'=>[
                'class'=>'btn btn-success'
            ]
        ], $config);

        return $this->renderButtonDropdown($label, $items, $config);
    }
}
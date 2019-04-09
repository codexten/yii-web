<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets;

use codexten\yii\helpers\ArrayHelper;
use codexten\yii\helpers\Html;
use Yii;
use yii\bootstrap\Nav;

/**
 * Class PageToolBar
 *
 * @package eii\metronic\widgets
 * @author Jomon Johnson <jomonjohnson.dev@gmail.com>
 */
class ButtonGroup extends Nav
{
    /**
     * @var icon positions
     */
    const ICON_POSITION_LEFT = 'left';
    const ICON_POSITION_RIGHT = 'right';

    /**
     * @var bool
     */
    public $encodeLabels = false;
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - icon
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: bool, optional, whether the item should be on active state or not.
     * - dropDownOptions: array, optional, the HTML options that will passed to the [[Dropdown]] widget.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     * - encode: bool, optional, whether the label will be HTML-encoded. If set, supersedes the $encodeLabels option for only this item.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var array
     */
    public $defaultItemConfig = [
        'class' => 'btn',
    ];
    /**
     * @var string
     */
    public $iconPosition;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Html::removeCssClass($this->options, ['widget' => 'nav']);
        if ($this->iconPosition === null) {
            $this->iconPosition = self::ICON_POSITION_LEFT;
        }
        $this->normalize();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->getView()->registerCss("#{$this->id} li {display: inline;}");

        return parent::run();
    }


    /**
     * for normalizing items
     */
    protected function normalize()
    {
        $items = $this->items;
        foreach ($items as $key => $item) {
            $defaultClass = ArrayHelper::getValue($this->defaultItemConfig, 'class');

            if ($defaultClass) {
                Html::addCssClass($item, $defaultClass);
            }

            $item = ArrayHelper::merge($this->defaultItemConfig, $item);
            $visible = ArrayHelper::getValue($item, 'visible', true);
            if ($visible === false) {
                continue;
            }

            $_item = [];
            $label = ArrayHelper::getValue($item, 'label');
            $icon = ArrayHelper::getValue($item, 'icon');
            $class = ArrayHelper::getValue($item, 'class');
            $data = ArrayHelper::getValue($item, 'data');
            $form = ArrayHelper::getValue($item, 'form');
            $confirm = ArrayHelper::getValue($item, 'confirm');
            $method = ArrayHelper::getValue($item, 'method');
            $url = ArrayHelper::getValue($item, 'url');
            $options = ArrayHelper::getValue($item, 'options', []);
            if (ArrayHelper::getValue($item, 'items', false)) {
                $_item['items'] = $item['items'];
            }

            if ($label === null) {
                $label = ArrayHelper::getValue($item, 0);
            }
            if ($url === null && !isset($_item['items'])) {
                $url = ArrayHelper::getValue($item, 1);
            }
            if (empty($options)) {
                $url = ArrayHelper::getValue($item, 2, []);
            }


            if ($label) {
                $_item['label'] = $label;
            }

            if ($icon) {
                if ($this->iconPosition == self::ICON_POSITION_LEFT) {
                    $_item['label'] = $icon . ' ' . $label;
                } elseif ($this->iconPosition == self::ICON_POSITION_RIGHT) {
                    $_item['label'] = $label . ' ' . $icon;
                }
            }

            if ($class) {
                Html::addCssClass($options, $class);
            }

            if ($data) {
                $options['data'] = $data;
            }

            if ($form) {
                if ($url) {
                    $options['data']['form'] = $form;
                } else {
                    $options['onClick'] = "$('#{$form}').submit()";
                }
            }

            if ($confirm) {
                $options['data']['confirm'] = $confirm;
            }

            if ($method) {
                $options['data']['method'] = $method;
            }

            if ($options) {
                $_item['linkOptions'] = $options;
            }

            if (!$url) {
                $url = 'javascript:;';
            }

            $_item['url'] = $url;
            $_item['linkOptions'] = $options;
            $items[$key] = $_item;
        }

        $this->items = $items;
    }
}
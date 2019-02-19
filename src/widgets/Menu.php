<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/7/18
 * Time: 7:03 PM
 */

namespace codexten\yii\web\widgets;


/**
 * Class Menu
 *
 * @package codexten\yii\web\widgets
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @var \codexten\yii\web\components\Menu
     */
    public $menu;

    public function init()
    {
        $this->menu = \Yii::createObject($this->menu);
        $this->items = $this->menu->getItems();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/10/18
 * Time: 2:29 PM
 */

namespace codexten\yii\web\widgets;

use codexten\yii\web\Widget;
use Yii;
use BadMethodCallException;

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
}
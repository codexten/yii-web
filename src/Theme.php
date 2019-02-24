<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/1/18
 * Time: 12:15 PM
 */

namespace codexten\yii\web;


/**
 * Class Theme
 *
 * @package eii\thememanager
 */
class Theme extends \yii\base\Theme
{
    public $assets = [];

    public $bodyOptions = [];

    /**
     * @return self
     */
    public static function getComponent()
    {
        return app()->view->theme;
    }
}
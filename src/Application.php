<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/11/18
 * Time: 3:08 PM
 */

namespace codexten\yii\web;


use codexten\yii\base\ModuleTrait;

/**
 * Class Application
 *
 * @package codexten\yii\web
 * @author Jomon Johnson <jomon@entero.in>
 */
class Application extends \yii\web\Application
{
    use ModuleTrait;

    public function init()
    {
        $this->defaultRoute = \Yii::getAlias($this->defaultRoute);
        parent::init();
    }

}
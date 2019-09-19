<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 14/11/18
 * Time: 4:47 PM
 */

namespace codexten\yii\web;


use yii\helpers\Url;

/**
 * {@inheritdoc}
 */
class UrlManager extends \yii\web\UrlManager
{
    /**
     * {@inheritdoc}
     */
    public function createAbsoluteUrl($params, $scheme = null)
    {
        $params[0] = \Yii::getAlias($params[0]);

        return parent::createAbsoluteUrl($params, $scheme);
    }

}
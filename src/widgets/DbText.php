<?php

namespace codexten\yii\web\widgets;

use enyii\web\models\WidgetText;
use yii\base\Widget;
use Yii;

/**
 * Class DbText
 * Return a text block content stored in db
 * @package enyii\web\widgets\text
 */
class DbText extends Widget
{
    /**
     * @var string text block key
     */
    public $key;

    /**
     * @return string
     */
    public function run()
    {
        $cacheKey = [
            WidgetText::class,
            $this->key
        ];
        $content = Yii::$app->cache->get($cacheKey);
        if (!$content) {
            $model =  WidgetText::findOne(['key' => $this->key, 'status' => WidgetText::STATUS_ACTIVE]);
            if ($model) {
                $content = $model->body;
                Yii::$app->cache->set($cacheKey, $content, 60*60*24);
            }
        }
        return $content;
    }
}

<?php

namespace codexten\yii\web;

class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@codexten/yii/web/assets';
    public $js = [
        'js/enyii.js',
        'js/jquery.are-you-sure.js',
    ];
    public $css = [
        'css/enyii.css',
        'css/helpers.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}

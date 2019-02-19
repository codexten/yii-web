<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\imageCropper;

/**
 * Class AssetBundle
 * @package codexten\yii\web\widgets\imageCropper
 * @author Jomon Johnson <jomon@entero.in>
 */
class ImageCropperAssetBundle extends \enyii\web\AssetBundle
{

    public $js = [
        'js/cropper.min.js',
        'js/script.js',
    ];

    public $css = [
        'css/cropper.min.css',
        'css/style.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        parent::init();
    }


}
<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\imageCropper;

use enyii\base\InputWidget;
use enyii\helpers\ArrayHelper;
use enyii\helpers\Json;

/**
 * Class Widget
 *
 * @property string $imageId
 *
 * @package codexten\yii\web\widgets\imageCropper
 * @author Jomon Johnson <jomon@entero.in>
 */
class ImageCropperWidget extends InputWidget
{
    /**
     * @var string
     */
    public $imageUrl;
    /**
     * @var array Default cropper options https://github.com/fengyuanchen/cropper/blob/master/README.md#options
     */
    public $defaultPluginOptions = [
        'viewMode' => 2,
        'checkCrossOrigin' => false,
    ];
    /**
     * @var array Additional cropper options https://github.com/fengyuanchen/cropper/blob/master/README.md#options
     */
    public $pluginOptions = [];

    public function getImageId()
    {
        return $this->id . '-image';
    }

    public function run()
    {
        $this->pluginOptions = ArrayHelper::merge($this->defaultPluginOptions, $this->pluginOptions);

        echo $this->render('widget', ['widget' => $this]);
        $this->registerAsset();
    }

    protected function registerAsset()
    {
        ImageCropperAssetBundle::register($this->view);
        $value = $this->model->{$this->attribute};
        $initPositionData = $value ? Json::encode([
            'left' => $value['x'],
            'right' => $value['y'],
            'width' => $value['w'],
            'height' => $value['h'],
        ]) : '{}';

        // Additional plugin options
        $options = Json::encode($this->pluginOptions);
        $selector = "#$this->id .crop-image-container .original-image";
        $previewSelector = "#$this->id .preview";
        $dataXSelector = "#$this->id .crop-image-container .data-x";
        $dataYSelector = "#$this->id .crop-image-container .data-y";
        $dataWSelector = "#$this->id .crop-image-container .data-w";
        $dataHSelector = "#$this->id .crop-image-container .data-h";

        $js = <<<JS
var previews = $("$previewSelector");

var imageCropper = $("$selector");

imageCropper.cropper($.extend({
    built : function() {
        imageCropper.cropper("setCropBoxData", $initPositionData);
    },
    ready: function (e) {
        
        var clone = $(this).clone().removeClass('cropper-hidden');
        
        clone.css({
        display: 'block',
        width: '100%',
        minWidth: 0,
        minHeight: 0,
        maxWidth: 'none',
        maxHeight: 'none'
        });
        
        previews.css({
        width: '100%',
        overflow: 'hidden'
        }).html(clone);
    },
    crop: function (e) {
        $("$dataXSelector").val(Math.round(e.x));
        $("$dataYSelector").val(Math.round(e.y));
        $("$dataWSelector").val(Math.round(e.width));
        $("$dataHSelector").val(Math.round(e.height));
        
        var imageData = $(this).cropper('getImageData');
        var previewAspectRatio = e.width / e.height;
        
        previews.each(function () {
            var preview = $(this);
            var previewWidth = preview.width();
            var previewHeight = previewWidth / previewAspectRatio;
            var imageScaledRatio = e.width / previewWidth;
            
            preview.height(previewHeight).find('img').css({
            width: imageData.naturalWidth / imageScaledRatio,
            height: imageData.naturalHeight / imageScaledRatio,
            marginLeft: -e.x / imageScaledRatio,
            marginTop: -e.y / imageScaledRatio
            });
        });
    }
}, $options));


JS;

        $this->view->registerJs($js);
    }


}
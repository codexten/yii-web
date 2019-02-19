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
        if (($value = $this->model->{$this->attribute}) !== null && !empty($value)) {
            $this->pluginOptions['data'] = [
                'x' => (int)$value['x'],
                'y' => (int)$value['y'],
                'width' => (int)$value['w'],
                'height' => (int)$value['h'],
            ];
        }

        echo $this->render('widget', ['widget' => $this]);
    }

}
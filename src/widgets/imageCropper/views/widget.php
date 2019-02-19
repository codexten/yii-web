<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 * @author Jomon Johnson <jomon@entero.in>
 */

use enyii\helpers\Html;
use enyii\helpers\Json;
use enyii\web\View;
use codexten\yii\web\widgets\imageCropper\ImageCropperAssetBundle;
use codexten\yii\web\widgets\imageCropper\ImageCropperWidget;

/* @var $this View */
/* @var $widget ImageCropperWidget */

$imageCropperContainerId = "image-cropper-{$widget->id}";
$options = Json::encode($widget->pluginOptions);
$this->registerJs("runImageCroper('{$imageCropperContainerId}',{$options});");
ImageCropperAssetBundle::register($this);
?>
<div id="<?= $imageCropperContainerId ?>">
    <div class="row">
        <div class="col-md-9">
            <div class="img-container">
                <img id="<?= $imageCropperContainerId ?>-image" src="<?= $widget->imageUrl ?>" alt="Picture">
            </div>
        </div>
        <div class="col-md-3">
            <div class="docs-preview clearfix">
                <div class="img-preview preview-lg"></div>
                <div class="img-preview preview-md"></div>
                <div class="img-preview preview-sm"></div>
                <div class="img-preview preview-xs"></div>
            </div>

            <div class="docs-data">
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataX">X</label>

                    <?= Html::activeTextInput($widget->model, "$widget->attribute[x]", false, [
                        'class' => 'form-control',
                        'id' => "{$imageCropperContainerId}-dataX",
                        'placeholder' => 'x',
                    ]) ?>

                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataY">Y</label>

                    <?= Html::activeTextInput($widget->model, "$widget->attribute[y]", false, [
                        'class' => 'form-control',
                        'id' => "{$imageCropperContainerId}-dataY",
                        'placeholder' => 'y',
                    ]) ?>

                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataWidth">Width</label>

                    <?= Html::activeTextInput($widget->model, "$widget->attribute[w]", false, [
                        'class' => 'form-control',
                        'id' => "{$imageCropperContainerId}-dataWidth",
                        'placeholder' => 'width',
                    ]) ?>

                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataHeight">Height</label>

                    <?= Html::activeTextInput($widget->model, "$widget->attribute[h]", false, [
                        'class' => 'form-control',
                        'id' => "{$imageCropperContainerId}-dataHeight",
                        'placeholder' => 'height',
                    ]) ?>

                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataRotate">Rotate</label>

                    <?= Html::activeTextInput($widget->model, "$widget->attribute[or]", false, [
                        'class' => 'form-control',
                        'id' => "{$imageCropperContainerId}-dataRotate",
                        'placeholder' => 'rotate',
                    ]) ?>

                    <span class="input-group-addon">deg</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9 docs-buttons">

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move"
                        title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
              <span class="fa fa-arrows"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop"
                        title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
              <span class="fa fa-crop"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1"
                        title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10"
                        data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;move&quot;, -10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10"
                        data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;move&quot;, 10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                        data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;move&quot;, 0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0"
                        data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;move&quot;, 0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45"
                        title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;rotate&quot;, -45)">
              <span class="fa fa-rotate-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45"
                        title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;rotate&quot;, 45)">
              <span class="fa fa-rotate-right"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1"
                        title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;scaleX&quot;, -1)">
              <span class="fa fa-arrows-h"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1"
                        title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;scaleY&quot;, -1)">
              <span class="fa fa-arrows-v"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;crop&quot;)">
              <span class="fa fa-check"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;clear&quot;)">
              <span class="fa fa-remove"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" data-animation="false"
                  title="$().cropper(&quot;reset&quot;)">
              <span class="fa fa-refresh"></span>
            </span>
            </div>
        </div>
    </div>
</div>
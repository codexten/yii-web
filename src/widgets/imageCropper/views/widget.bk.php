<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 * @author Jomon Johnson <jomonjohnson.dev@gmail.com>
 */

use enyii\helpers\Html;
use enyii\web\View;
use codexten\yii\web\widgets\imageCropper\ImageCropperWidget;

/* @var $this View */
/* @var $widget ImageCropperWidget */
?>
<div id="<?= $widget->id ?>">
    <div class="crop-image-container">
        <div class="row">
            <div class="col-md-6">
                <img class="original-image" src="<?= $widget->imageUrl ?>">
            </div>
            <div class="col-md-6">
                <h3><?= Yii::t('entero:web', 'Preview') ?></h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="preview"></div>
                    </div>
                    <div class="col-md-2">
                        <div class="preview"></div>
                    </div>
                    <div class="col-md-1">
                        <div class="preview"></div>
                    </div>
                </div>

                <?= Html::activeTextInput($widget->model, "$widget->attribute[x]", false, ['class' => 'data-x']) ?>

                <?= Html::activeTextInput($widget->model, "$widget->attribute[y]", false, ['class' => 'data-y']) ?>

                <?= Html::activeTextInput($widget->model, "$widget->attribute[w]", false, ['class' => 'data-w']) ?>

                <?= Html::activeTextInput($widget->model, "$widget->attribute[h]", false, ['class' => 'data-h']) ?>

            </div>
        </div>
    </div>
</div>
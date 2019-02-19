<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\ajaxProgress;

use enyii\web\AssetBundle;
use enyii\web\View;

/**
 * Class AjaxProgressAsset
 * @package codexten\yii\web\widgets\ajaxProgress
 * @author Junaid Rahman PV <junaid@entero.in>
 * @author Jomon Johnson <jomon@entero.in>
 */
class AjaxProgressAsset extends AssetBundle
{
    public $sourcePath = '@entero/entero-web/src/widgets/ajaxProgress/assets';
    public $js = [
        'js/ajax-progress.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

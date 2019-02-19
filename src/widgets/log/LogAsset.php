<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\log;

use enyii\web\AssetBundle;
use enyii\web\View;

/**
 * Class LogAsset
 * @package codexten\yii\web\widgets\log
 * @author Junaid Rahman PV <junaid@entero.in>
 */
class LogAsset extends AssetBundle
{
    public $css = [];

    public $js = [
        'js/ajax-log.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $jsOptions = [
        ['position' => View::POS_HEAD]
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
    }
}

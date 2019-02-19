<?php
/**
 * Author: Junaid Rahman <junaid.entero@gmail.com>
 */

namespace codexten\yii\web\widgets\PlacePicker;

use enyii\web\AssetBundle;
use enyii\web\View;

class MapAsset extends AssetBundle
{
    public $css = [

    ];

    public $js = [
        'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $key = [

    ];

    public $jsOptions = [
        ['position' => View::POS_HEAD]
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
        $this->key = env('GOOGLE_API_KEY');
        parent::init();
        $this->js = [
            'js/map-kit.js',
            'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . $this->key,
        ];

    }
}

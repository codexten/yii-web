<?php

namespace codexten\yii\web\widgets\widget;

use enyii\helpers\ArrayHelper;
use Yii;
use yii\imperavi\Widget;

class Imperavi extends Widget
{
    public $minHeight = 200;
    public $maxHeight = '';
    
    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        
        $config = ArrayHelper::merge($this->defaultConfig(), $config);
        
        parent::__construct($config);
    }
    
    public function defaultConfig()
    {
        return [
            'options' => [
                'minHeight' => $this->minHeight,
                'maxHeight' => $this->maxHeight,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => ['/file-storage/upload-imperavi'],
                'buttons' => ['bold', 'alignment'],
            ],
        ];
    }
}
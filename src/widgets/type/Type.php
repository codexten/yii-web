<?php
namespace codexten\yii\web\widgets\type;

use enyii\helpers\ArrayHelper;
use kartik\widgets\Typeahead;
use yii\web\JsExpression;
use yii\helpers\Url;
use Yii;

class Type extends typeahead
{
    public $placeholder = '';
    public $data = [];

    public function __construct(array $config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }

        $config = ArrayHelper::merge($this->defaultConfig(), $config);
        parent::__construct($config);
    }

    protected function defaultConfig()
    {
        return [
            'dataset' => [
                [
                    'local' => $this->data,
                    'limit' => 10
                ]
            ],
            'pluginOptions' => ['highlight' => true],
            'options' => ['placeholder' => $this->placeholder],
        ];
    }
}
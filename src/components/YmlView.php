<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 9/21/18
 * Time: 10:17 PM
 */

namespace codexten\yii\web\components;


use codexten\yii\web\widgets\FormBuilder;
use codexten\yii\web\widgets\importer\DI;
use yii\base\Component;
use yii\di\Instance;
use yii\helpers\Inflector;

class YmlView extends Component
{
    public $params = null;
    public $context = [];
    public $config = [];

    private $_tags = [];

    public function render()
    {

        return $this->renderYml($this->config);
    }

    protected function renderYml($config)
    {
        $config = is_array($config) ? $config : [$config];
        foreach ($config as $type => $value) {
            if (is_integer($type)) {
                $out .= ">>> Type : $type</br>";
                $type = $value;
            }

            if ($type == 'row') {
                $out .= $this->renderRow();
                continue;
            }

            if ($type == 'form') {
                $out .= $this->renderForm($value);
                continue;
            }

            if ($type == 'title') {
                $this->setTitle($value);
                continue;
            }

            if ($type == 'layout') {
                $this->setLayout($value);
                continue;
            }
        }

        return $out;
    }

    protected function setLayout($layout)
    {
        \Yii::$app->controller->layout = $layout;
    }

    protected function setTitle($title)
    {
        \Yii::$app->view->title = $title;
    }

    protected function renderForm($config)
    {
        $out = "From started</br>";
        foreach ($config['fields'] as $field) {

            $out .= $this->renderYml($field);
        }

        return $out;
    }

    protected function renderRow()
    {
        return "Row started</br>";
    }

    protected function renderField()
    {

    }

    protected function renderHtml()
    {

    }
}
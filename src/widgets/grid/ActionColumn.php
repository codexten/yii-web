<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\grid;

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class ActionColumn
 * @package codexten\yii\web\widgets\grid
 * @author Jasar TP <jasar@entero.in>
 */
class ActionColumn extends \kartik\grid\ActionColumn
{
    use ColumnTrait;

    public $template = '{update}';
    public $keyAttribute = 'id';
    public $viewUrl = false;
    public $updateUrl = false;
    public $header = false;

    public function init()
    {
        parent::init();

        $this->setDefaultOptions();
    }

    private function setDefaultOptions()
    {
        $this->header = $this->header ?: Html::a('<i class="fa fa-cog"></i>', $this->updateUrl,
            ['class' => 'btn-lg', 'style' => ['padding' => 0], 'title' => 'Actions']);
    }

    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     *
     * @param string $action the button name (or action ID)
     * @param \yii\db\ActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param int $index the current row index
     *
     * @return string the created URL
     */
    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        } else {
            $params = is_array($key) ? $key : [$this->keyAttribute => $model[$this->keyAttribute]];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }

}
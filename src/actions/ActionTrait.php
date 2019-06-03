<?php


namespace codexten\yii\web\actions;


use codexten\yii\helpers\ArrayHelper;

trait ActionTrait
{
    /**
     * @var string name of the view, which should be rendered
     */
    public $view;

    private $_viewParams = [];

    /**
     * @param $view
     * @param array $params
     *
     * @return string
     */
    public function render($view = null, $params = [])
    {
        $this->controller->layout = $this->layout;
        $params = ArrayHelper::merge($params, $this->_viewParams);

        return $this->controller->render($view ?: $this->view, $params);
    }

    public function setViewParams($params, $map = [])
    {
        foreach ($map as $key => $replace) {
            if (isset($params[$key])) {
                $params[$replace] = $params[$key];
                unset($params[$key]);
            }
        }

        $this->_viewParams = ArrayHelper::merge($this->_viewParams, $params);
    }
}

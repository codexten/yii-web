<?php

namespace codexten\yii\web\actions;

use codexten\yii\actions\IndexActionInterface;
use codexten\yii\actions\IndexActionTrait;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

class IndexAction extends Action implements IndexActionInterface
{
    const WIDGET_TYPE_GRID = 'grid';
    const WIDGET_TYPE_LIST = 'list';

    use IndexActionTrait;

    public $params = [];
    public $widgetType = self::WIDGET_TYPE_GRID;

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $searchModel = $this->newSearchModel();
        $dataProvider = $this->prepareDataProvider($searchModel);

        $params = ArrayHelper::merge([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'action' => $this,
        ], $this->params);

        return $this->controller->render($this->id, $params);
    }
}

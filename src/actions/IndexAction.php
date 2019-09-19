<?php

namespace codexten\yii\web\actions;

use codexten\yii\actions\IndexActionInterface;
use codexten\yii\actions\IndexActionTrait;
use yii\base\InvalidConfigException;

class IndexAction extends Action implements IndexActionInterface
{
    use IndexActionTrait;

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


        return $this->controller->render($this->id, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}

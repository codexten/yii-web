<?php

namespace codexten\yii\web\controllers;

/**
 * Site controller
 *
 * @author Jomon Johnson <jomonjohnson.dev@gmail.com>
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/site/error',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}

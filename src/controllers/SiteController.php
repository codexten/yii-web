<?php

namespace codexten\yii\web\controllers;

use yii\web\Controller;

/**
 * Site controller
 *
 * @author Jomon Johnson <jomonjohnson.dev@gmail.com>
 */
class SiteController extends Controller
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

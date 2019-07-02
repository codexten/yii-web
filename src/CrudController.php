<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:17 PM
 */

namespace codexten\yii\web;

use codexten\yii\web\actions\CreateAction;
use codexten\yii\web\actions\DeleteAction;
use codexten\yii\web\actions\IndexAction;
use codexten\yii\web\actions\UpdateAction;
use codexten\yii\web\actions\ViewAction;
use yii\web\NotFoundHttpException;

class CrudController extends Controller
{
    public $modelClass;

    public $enabledActions = [
        'index',
        'create',
        'update',
        'delete',
    ];

//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
//        ];
//    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = [];

        if (isset($this->enabledActions['index'])) {
            $actions['index'] = [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (isset($this->enabledActions['create'])) {
            $actions['create'] = [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (isset($this->enabledActions['update'])) {
            $actions['update'] = [
                'class' => UpdateAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (isset($this->enabledActions['delete'])) {
            $actions['delete'] = [
                'class' => DeleteAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (isset($this->enabledActions['view'])) {
            $actions['delete'] = [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        return $actions;
    }

    public function findOne($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

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
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class CrudController extends Controller
{
    public $modelClass;
    public $newSearchModel;

    public $enabledActions = [
        'index',
        'create',
        'update',
        'delete',
    ];

    public $pathMaps = [];

    public function init()
    {
        \Yii::$app->view->theme->pathMap[$this->viewPath] = ArrayHelper::merge([$this->viewPath], $this->getPathMaps());

        parent::init();
    }

    public function getPathMaps()
    {
        return [
            '@codexten/yii/web/views/crud',
        ];
    }

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

        if (in_array('index', $this->enabledActions)) {
            $actions['index'] = [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'newSearchModel' => $this->newSearchModel,
            ];
        }

        if (in_array('create', $this->enabledActions)) {
            $actions['create'] = [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (in_array('update', $this->enabledActions)) {
            $actions['update'] = [
                'class' => UpdateAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (in_array('delete', $this->enabledActions)) {
            $actions['delete'] = [
                'class' => DeleteAction::class,
                'modelClass' => $this->modelClass,
            ];
        }

        if (in_array('view', $this->enabledActions)) {
            $actions['view'] = [
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

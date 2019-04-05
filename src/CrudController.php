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

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass,
            ],
//            'view' => [
//                'class' => ViewAction::class,
//            ],
            'update' => [
                'class' => UpdateAction::class,
                'modelClass' => $this->modelClass,
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => $this->modelClass,
            ],
        ];
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
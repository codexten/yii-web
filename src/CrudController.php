<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:17 PM
 */

namespace codexten\yii\web;

use codexten\yii\web\actions\Action;
use codexten\yii\web\actions\CreateAction;
use codexten\yii\web\actions\DeleteAction;
use codexten\yii\web\actions\IndexAction;
use codexten\yii\web\actions\UpdateAction;
use codexten\yii\web\actions\ViewAction;
use codexten\yii\web\components\Controller;

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
            ],
            'create' => [
                'class' => CreateAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
            ],
            'update' => [
                'class' => UpdateAction::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
            ],
        ];
    }
}
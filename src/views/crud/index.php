<?php

use codexten\yii\web\actions\IndexAction;
use codexten\yii\web\widgets\IndexPage;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel */
/* @var $_params_ array */
/* @var $action IndexAction */

$this->title = Inflector::pluralize(Inflector::camel2words(Inflector::id2camel(Yii::$app->controller->id)))
?>

<?php $page = IndexPage::begin([
    'title' => $this->title,
]) ?>

<?php $page->beginContent('main-actions') ?>

<?= $this->render('index/_mainActions', ArrayHelper::merge($_params_,compact(['page']))) ?>

<?php $page->endContent() ?>

<?php $page->beginContent('table') ?>

<?php if ($action->widgetType == IndexAction::WIDGET_TYPE_GRID): ?>

    <?= $this->render('index/_grid', $_params_) ?>

<?php endIf; ?>

<?php if ($action->widgetType == IndexAction::WIDGET_TYPE_LIST): ?>

    <?= $this->render('index/_list', $_params_) ?>

<?php endIf; ?>

<?php $page->endContent() ?>

<?php $page->end() ?>

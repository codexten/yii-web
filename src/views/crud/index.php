<?php

use codexten\yii\web\widgets\IndexPage;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel */
/* @var $_params_ array */

$this->title = Yii::t('gnt:core', 'Staff Users');
?>

<?php $page = IndexPage::begin([
    'title' => $this->title,
]) ?>

<?php $page->beginContent('main-actions') ?>

<?= $this->render('index/_mainActions', compact(['page'])) ?>

<?php $page->endContent() ?>

<?php $page->beginContent('table') ?>

<?= $this->render('_grid', $_params_) ?>

<?php $page->endContent() ?>

<?php $page->end() ?>

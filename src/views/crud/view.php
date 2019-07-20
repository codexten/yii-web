<?php

use codexten\yii\web\widgets\Page;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model codexten\gnt\admin\modules\user\models\StaffUser */

$this->title = $model->id;
?>

<?php $page = Page::begin([
    'title' => $this->title,
]) ?>

<?php $page->beginContent('content') ?>

<?php $page->endContent() ?>

<?php $page->end() ?>

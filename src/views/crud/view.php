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

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'username',
        'email',
        'password_hash',
        'auth_key',
        'access_token',
        'logged_at',
    ],
]) ?>

<?php $page->endContent() ?>

<?php $page->end() ?>

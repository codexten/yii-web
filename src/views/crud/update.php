<?php

use codexten\yii\web\widgets\UpdatePage;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model Model */

$this->title = Yii::t('gnt:core', 'Update {modelName}: {nameAttribute}', [
    'nameAttribute' => '' . $model->id,
    'modelName' => Inflector::camel2words(StringHelper::basename($model::className())),
]);
?>
<?php $page = UpdatePage::begin() ?>

<?php $page->beginContent('form') ?>

<?= $this->render('_form', ['model' => $model]) ?>

<?php $page->endContent() ?>

<?php $page->end() ?>

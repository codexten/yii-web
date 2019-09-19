<?php

use codexten\yii\web\widgets\CreatePage;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */

$this->title = Yii::t('gnt:core', 'Create {modelName}', [
    'modelName' => Inflector::camel2words(StringHelper::basename($model::className())),
]);

?>
<?php $page = CreatePage::begin() ?>

<?php $page->beginContent('form') ?>

<?= $this->render('_form', ['model' => $model]) ?>

<?php $page->endContent() ?>

<?php $page->end() ?>

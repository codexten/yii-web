<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 10/8/18
 * Time: 8:30 PM
 */
/* @var $this \yii\web\View */
/* @var $widget \codexten\yii\web\widgets\ViewPage */

$widget = $this->context;
?>

<?php $this->beginContent('@entero/web/widgets/views/page/default.php'); ?>

<?= $widget->renderContent('content') ?>

<?php $this->endContent() ?>

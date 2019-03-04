<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 10/8/18
 * Time: 8:30 PM
 */
/* @var $this \yii\web\View */
/* @var $widget \codexten\yii\web\widgets\IndexPage */

$widget = $this->context;
?>

<?php $this->beginContent('@app/widgets/views/page/default.php'); ?>

<?= $widget->renderContent('table') ?>

<?php $this->endContent() ?>

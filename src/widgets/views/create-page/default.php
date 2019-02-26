<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 10/19/18
 * Time: 9:51 AM
 */
/* @var $widget \codexten\yii\web\widgets\IndexPage */

$widget = $this->context;
?>
<?php $this->beginContent('@app/widgets/views/page/default.php'); ?>

<?= $widget->renderContent('form') ?>

<?php $this->endContent() ?>

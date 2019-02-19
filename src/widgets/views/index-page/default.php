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

<?php $this->beginContent('@entero/web/widgets/views/page/default.php'); ?>

<?php
    echo $widget->renderContent('content');
?>

<code><?= Yii::$app->themeManager->defaultTheme ?></code> index page Widget not configured

<?php $this->endContent() ?>

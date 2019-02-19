<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 * @author Jomon Johnson <jomon@entero.in>
 * @author Ashlin A <ashlin@entero.in>
 */

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginPage(); ?>

<?php $this->beginContent('@app/views/layouts/base.php'); ?>

<?= $content ?>

<?php $this->endContent() ?>
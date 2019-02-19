<?php

/* @var  $this \yii\web\View */
/* @var  $content string */

app()->themeManager->registerAssets();
?>

<?php $this->beginContent('@app/views/layouts/_clear.php'); ?>

<?= $content ?>

<?php $this->endContent(); ?>
<?php

/* @var  $this View */
/* @var  $content string */

app()->themeManager->registerAssets();

use odaialali\yii2toastr\ToastrFlash;
use yii\web\View;

?>

<?php $this->beginContent('@app/views/layouts/_clear.php'); ?>

<?= ToastrFlash::widget([
    'options' => [
        'positionClass' => 'toast-top-right',
    ],
]); ?>

<?= $content ?>

<?php $this->endContent(); ?>

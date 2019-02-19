<?php

/* @var $this \enyii\web\View */
/* @var $form \codexten\yii\web\widgets\ActiveForm */
/* @var $model \enyii\db\ActiveRecord */
/* @var $label string */
/* @var $key string */
/* @var $hint string */
/* @var $config array */

?>

<?= $form->field($model, "value")
    ->widget(\codexten\yii\web\widgets\imageUpload\ImageUpload::class, $config['options'])
    ->hint($hint)
    ->label($label) ?>


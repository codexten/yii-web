<?php
/* @var $this \enyii\web\View */
/* @var $form \codexten\yii\web\widgets\ActiveForm */
/* @var $model \enyii\db\ActiveRecord */
/* @var $label string */
/* @var $options string */
/* @var $key string */
/* @var $hint string */
/* @var $config array */
?>

<?= $form->field($model, "[{$key}]value", $options)
    ->widget('trntv\aceeditor\AceEditor', $config['options'])
    ->hint($hint)
    ->label($label) ?>


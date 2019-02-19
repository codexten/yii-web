<?php

namespace codexten\yii\web\actions;

/**
 * ActionEvent represents the event triggered by admin action.
 */
class ActionEvent extends \yii\base\ActionEvent
{
    /**
     * @var \yii\base\Model|null associated model instance.
     */
    public $model;
}
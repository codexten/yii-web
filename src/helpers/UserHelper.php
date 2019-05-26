<?php


namespace codexten\yii\web\helpers;


class UserHelper
{
    public static function getMyId()
    {
        return \Yii::$app->user->getId();
    }

}
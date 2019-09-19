<?php


namespace codexten\yii\web\helpers;


class UserHelper
{
    public static function getMyId()
    {
        return \Yii::$app->user->getId();
    }

    /**
     * @param $permissionName
     * @param array $params
     * @param bool $allowCaching
     *
     * @return bool
     */
    public static function can($permissionName, $params = [], $allowCaching = true)
    {
        return \Yii::$app->user->can($permissionName, $params, $allowCaching);
    }

}

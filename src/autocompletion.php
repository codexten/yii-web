<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 22/11/18
 * Time: 11:59 AM
 */

use codexten\yii\web\ThemeManager;
use codexten\yii\web\User;

/**
 * @property User $user
 * @property ThemeManager $themeManager
 */
abstract class BaseApplication extends yii\base\Application
{
}
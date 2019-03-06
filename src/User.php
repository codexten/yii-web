<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 10/12/18
 * Time: 8:05 PM
 */

namespace codexten\yii\web;


class User extends \yii\web\User
{
    public $logoutUrl = ['/site/logout'];
    public $registerUrl = ['/site/register'];

}
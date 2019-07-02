<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/1/18
 * Time: 12:15 PM
 */

namespace codexten\yii\web;


use Yii;
use yii\helpers\FileHelper;

/**
 * Class Theme
 *
 * @package eii\thememanager
 */
class Theme extends \yii\base\Theme
{
    public $assets = [];

    public $bodyOptions = [];

    /**
     * @return self
     */
    public static function getComponent()
    {
        return app()->view->theme;
    }

    /**
     * {@inheritDoc}
     */
    public function applyTo($path)
    {
        $return = parent::applyTo($path);
        if (is_file($return)) {
            return $return;
        }

        // for debug
        $path = FileHelper::normalizePath($path);
        $debug['path'] = $path;

        $pathMap = $this->pathMap;
        $items = [];
        foreach ($pathMap as $key => $paths) {
            $key = Yii::getAlias($key);
            foreach ($paths as $path) {
                $items[$key][] = Yii::getAlias($path);
            }
        }

        $debug['pathMap'] = $items;
        echo '<pre>';
        var_dump($debug);
        echo '</pre>';
        exit;
    }
}

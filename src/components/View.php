<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 9/21/18
 * Time: 8:32 PM
 */

namespace codexten\yii\web\components;

use Symfony\Component\Yaml\Yaml;
use yii\base\InvalidCallException;
use yii\base\ViewContextInterface;
use yii\web\Controller;

class View extends \yii\web\View
{

//    public function render($view, $params = [], $context = null)
//    {
//        if ($context instanceof ViewContextInterface) {
//
//            $config = $this->getViewConfig($view, $params, $context);
//
//            if (!empty($config)) {
//                return (new YmlView([
//                    'config' => $config,
//                    'params' => $params,
//                    'context' =>$context,
//                ]))->render();
//            }
//        }
//
//        $viewFile = $this->findViewFile($view, $context);
//
//        return $this->renderFile($viewFile, $params, $context);
//    }

    /**
     * @param $view
     * @param array $params
     * @param ViewContextInterface $context
     */
    protected function getViewConfig($view, $params = [], $context = null)
    {
        $ymlFile = $this->getYmlFile($view, $context);

        return $ymlFile ? Yaml::parseFile($ymlFile) : [];
    }

    protected function getYmlFile($view, $context = null)
    {
        $file = $view . '.yml';

        if ($context instanceof Controller) {

            if ($context->module) {
                $ymlFile = $context->module->getViewPath() . DIRECTORY_SEPARATOR . $file;

                if (file_exists($ymlFile)) {
                    return $ymlFile;
                }
            }

            $ymlFile = $context->getViewPath() . DIRECTORY_SEPARATOR . $file;
            if (file_exists($ymlFile)) {
                return $ymlFile;
            }
        }

        return false;
    }
}
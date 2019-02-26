<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 7/31/18
 * Time: 8:52 PM
 */

namespace codexten\yii\web;


use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

/**
 * Class ThemeManager
 *
 * @package codexten\yii\web
 * @author Jomon Johnson <jomon@entero.in>
 */
class ThemeManager extends Component implements BootstrapInterface
{
    /**
     * @var string|Theme default theme id
     */
    public $defaultTheme;
    /**
     * @var array of theme
     */
    public $themes;
    /**
     * @var AssetBundle[] assets to be registered at bootstrap
     */
    public $assets = [];

    /**
     * @var Theme
     */
    private $_theme;

    protected $_view;

    /**
     * @return \yii\web\View
     * @see setView
     */
    public function getView()
    {
        if ($this->_view === null) {
            $this->_view = Yii::$app->getView();
        }

        return $this->_view;
    }

    /**
     * @param Application $app
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        $this->setTheme();
    }

    protected function setTheme()
    {
        $config = $this->themes[$this->defaultTheme];
        $defaultConfig = ArrayHelper::toArray($this->getView()->theme);
        unset($defaultConfig['pathMap']);
        $config = ArrayHelper::merge($defaultConfig, $config);
        $pathMap = $this->getView()->theme->pathMap;
        $pathMap = $this->reversePathMap($pathMap);
//        $config['pathMap'] = ArrayHelper::merge($config['pathMap'], $pathMap);
        $config['pathMap'] = ArrayHelper::merge($config['pathMap'],$pathMap);
        $this->_theme = \Yii::createObject($config);

//        echo '<pre>';
////        var_dump(Yii::getAlias('@app/views/layouts'));
////        var_dump(Yii::getAlias('@codexten/yii/bootswatch/views/layouts'));
//        var_dump($config['pathMap']);
//        echo '</pre>';
//        exit;

        $this->getView()->theme = $this->getTheme();
    }

    protected function reversePathMap($pathMaps)
    {
        $items = [];
        foreach ($pathMaps as $key => $maps) {
            $maps = is_array($maps) ? $maps : [$maps];
            $items[$key] = array_reverse($maps);
        }

        return $items;
    }


    /**
     * @return Theme
     */
    protected function getTheme()
    {
        return $this->_theme;
    }


    /**
     * Register all the assets.
     */
    public function registerAssets()
    {
        foreach (array_merge($this->assets, $this->getTheme()->assets) as $asset) {
            /** @var AssetBundle $asset */
            $asset::register($this->getView());
        }
    }

}
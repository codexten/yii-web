<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\log;

use codexten\yii\helpers\Html;
use entero\metronic4\widgets\Widget;
use entero\process\Process;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

/**
 * Class AjaxLog displays message returned from given url
 * The Log will be refreshed with an interval of given refreshRate
 * For example,
 *
 * ```php
 * // Simple AjaxLog
 * echo AjaxLog::widget(['url' => Url::to(['process/logs', 'id' => $model->id])])
 *
 * // sample controller action
 *  public function actionLogs($id)
 * {
 *      \Yii::$app->response->format = Response::FORMAT_JSON;
 *
 *      return ['log' => $logMessages];
 * }
 *
 * // sample response format(Json format)
 * {"log":"Log messages"}
 * ```
 * @package codexten\yii\web\widgets
 * @author Junaid Rahman PV <junaid@entero.in>
 */
class Log extends Widget
{
    /**
     * @var string url of log file or action
     */
    public $url;
    /**
     * @var boolean
     */
    public $visible = true;
    /**
     * @var array options for the div tag
     */
    public $containerOptions = [];
    /**
     * @var integer interval for ajax refresh in millisecond
     */
    public $refreshRate = 1000;

    /**
     * @return bool|void
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->visible) {
            return false;
        }
        parent::init();
        if (!$this->url) {
            throw new InvalidConfigException('url must be specified');
        }
        $this->containerOptions['id'] = $this->getId(true);
        $this->setJs();
    }

    /**
     * @return string|void
     */
    public function run()
    {
        echo Html::beginTag('div', $this->containerOptions);
        echo Html::endTag('div');
    }

    /**
     * set scripts which updates the log with ajax call
     */
    public function setJs()
    {
        LogAsset::register($this->view);

        $options = Json::encode([
            'url' => $this->url,
            'refreshRate' => $this->refreshRate,
            'endStatus' => Process::STATUS_STOPPED,
        ]);
        $this->getView()->registerJs("jQuery('#{$this->getId()}').updateLog({$options});");
    }
}
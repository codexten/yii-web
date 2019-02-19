<?php

namespace codexten\yii\web\widgets\ajaxProgress;

/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

use entero\process\mongo\Process;
use yii\bootstrap\Progress;
use yii\helpers\Json;

/**
 * Class AjaxProgress
 * @package codexten\yii\web\widgets\ajaxProgress
 * @author Junaid Rahman PV <junaid@entero.in>
 * @author Jomon Johnson <jomon@entero.in>
 */
class AjaxProgress extends Progress
{
    /**
     * @var string url to get current progress of a process
     */
    public $statusUrl;
    /**
     * @var integer interval for ajax refresh in millisecond
     */
    public $refreshRate = 2500;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->barOptions['id'] = 'progress-' . $this->getId(true);
        $this->registerAsset();
        $this->clientEvents;
    }

    /**
     * Register asset
     */
    protected function registerAsset()
    {
        AjaxProgressAsset::register($this->view);

        $options = Json::encode([
            'statusUrl' => $this->statusUrl,
            'refreshRate' => $this->refreshRate,
            'endStatus' => Process::STATUS_STOPPED,
        ]);
        $this->getView()->registerJs("jQuery('#{$this->barOptions['id']}').ajaxProgress({$options});");
        $this->registerClientEvents();
    }
}
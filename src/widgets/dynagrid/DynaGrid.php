<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\dynagrid;

use kartik\grid\GridView;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class DynaGrid
 * @package codexten\yii\web\widgets\dynagrid
 * @author Junaid Rahman <junaid.entero@gmail.com>
 * @author Jomon Johnson <jomon@entero.in>
 */
class DynaGrid extends \kartik\dynagrid\DynaGrid
{
    public $checkBoxFormId;
    public $resetUrl = ['index'];
    public $storage = self::TYPE_DB;
    private $_gridOptions = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->gridOptions['dataColumnClass'] = '\codexten\yii\web\widgets\grid\DataColumn';
        parent::init();
        $this->setDefaultOptions();
        $this->gridOptions = ArrayHelper::merge($this->_gridOptions, $this->gridOptions);
        $this->allowThemeSetting = false;
    }

    private function setDefaultOptions()
    {

        $this->_gridOptions['options']['class'] = 'grid-view table';

        $csrfToken = Yii::$app->request->getCsrfToken();

        $this->_gridOptions['panelBeforeTemplate'] = <<<HTML
    <div class="pull-left">{summary}</div>
    <div class="pull-right">
        <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
            {toolbar}
        </div>
    </div>
    {before}
    <div class="clearfix"></div>
HTML;

        $this->_gridOptions['panelTemplate'] = <<<HTML
<div class="{prefix}{type}">
    {panelHeading}
    {panelBefore}
    <form id="{$this->checkBoxFormId}" method="post">
        <input type="hidden" name="_csrf" value="{$csrfToken}"/>
        {items}
    </form>
    {panelFooter}
</div>
HTML;
        $this->_gridOptions['pjax'] = true;
        $this->_gridOptions['panel']['type'] = 'primary';
        $this->_gridOptions['panel']['heading'] = false;
        $this->_gridOptions['panel']['showPageSummary'] = false;
        $this->_gridOptions['panel']['floatHeader'] = false;
        $this->_gridOptions['export']['header'] = '';
        $this->_gridOptions['export']['fontAwesome'] = true;
        $this->_gridOptions['exportConfig'] = [
            GridView::CSV => ['label' => Yii::t('entero:web', 'CSV'),],
            GridView::TEXT => ['label' => Yii::t('entero:web', 'Text'),],
            GridView::EXCEL => ['label' => Yii::t('entero:web', 'Excel'),],
        ];
        $this->_gridOptions['toolbar'] = [
            [
                'content' => Html::a('<i class="fa fa-refresh"></i>', $this->resetUrl,
                    ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid']),
            ],
            '{export}',
            ['content' => '{dynagridFilter}{dynagridSort}{dynagrid}'],
        ];
    }
}

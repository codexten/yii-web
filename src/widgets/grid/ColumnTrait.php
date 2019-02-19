<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\grid;

use yii\helpers\Html;

/**
 * Class ColumnTrait
 * @package codexten\yii\web\widgets\grid
 * @author Jasar TP <jasar@entero.in>
 */
trait ColumnTrait
{
    /**
     * @var bool string
     */
    public $maxWidth = false;

    /**
     * @return mixed
     */
    protected function parseFormat()
    {
        if (trim($this->maxWidth) != '') {
            Html::addCssStyle($this->headerOptions, "max-width:{$this->maxWidth} !important;");
            Html::addCssStyle($this->pageSummaryOptions, "max-width:{$this->maxWidth} !important;");
            Html::addCssStyle($this->footerOptions, "max-width:{$this->maxWidth} !important;");
            Html::addCssStyle($this->contentOptions, "max-width:{$this->maxWidth} !important;");
            if (trim($this->width) == '') {
                Html::addCssStyle($this->headerOptions, "width:{$this->maxWidth};");
                Html::addCssStyle($this->pageSummaryOptions, "width:{$this->maxWidth};");
                Html::addCssStyle($this->footerOptions, "width:{$this->maxWidth};");
            }
        }

        return parent::parseFormat();
    }

}
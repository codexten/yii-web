<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\grid;

/**
 * Class CheckboxColumn
 * @package codexten\yii\web\widgets\grid
 * @author Jasar TP <jasar@entero.in>
 */
class CheckboxColumn extends \kartik\grid\CheckboxColumn
{
    use ColumnTrait;

    public $width = '20px';
}
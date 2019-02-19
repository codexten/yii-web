<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\grid;

/**
 * Class SerialColumn
 * @package codexten\yii\web\widgets\grid
 * @author Jasar TP <jasar@entero.in>
 */
class SerialColumn extends \kartik\grid\SerialColumn
{
    use ColumnTrait;

    public $width = '20px';
}
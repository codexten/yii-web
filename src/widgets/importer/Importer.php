<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets\importer;

use arogachev\excel\helpers\PHPExcelHelper;
use codexten\yii\web\widgets\importer\BaseImporter;
use codexten\yii\web\widgets\importer\DI;
use arogachev\excel\import\exceptions\ImportException;
use arogachev\excel\import\exceptions\RowException;
use Yii;
use yii\db\Exception;

/**
 * Class Importer
 * @package codexten\yii\web\widgets\importer
 * @author Junaid Rahman <junaid.entero@gmail.com>
 */
class Importer extends BaseImporter
{
    public $errors = [];
    public $rowCount;
    public $file;

    /**
     * @inheritdoc
     */
    protected function fillModels($rows)
    {
        $c = 1;
        foreach ($rows as $row) {
            if (PHPExcelHelper::isRowEmpty($row)) {
                break;
            }
            if ($c == 1) {
                if (!$this->_standardModels[0]->parseAttributeNames($row)) {
                    throw new RowException($row, 'Attribute names must be placed in first filled row.');
                }
            } else {
                $this->_models[] = new Model([
                    'row' => $row,
                    'standardModel' => $this->_standardModels[0],
                ]);
            }
            $c++;
        }
    }

    /**
     * @inheritdoc
     */
    protected function safeRun()
    {
        parent::safeRun();

        $this->fillModels($this->_phpExcel->getActiveSheet()->getRowIterator());
        $this->rowCount = count($this->_models);

        foreach ($this->_models as $model) {
            $model->load();
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($this->_models as $model) {
                $model->save();
            }
            if (!$this->errors) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }

        $this->trigger(self::EVENT_RUN);
    }

    public static function addError($row, $message, $col)
    {
        if (array_key_exists($row, DI::getImporter()->errors)) {
            array_push(DI::getImporter()->errors[$row], [$col => $message]);
        } else {
            if (empty(DI::getImporter()->errors)) {
                DI::getImporter()->errors = [$row => [0 => [$col => $message]]];
            } else {
                array_push(DI::getImporter()->errors, [$row => [$col => $message]]);
            }
        }
    }
}

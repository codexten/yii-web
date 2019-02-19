<?php

namespace codexten\yii\web\widgets\importer;

use codexten\yii\web\widgets\importer\DI;
use codexten\yii\web\widgets\importer\components\Model as BaseModel;
use PHPExcel_Worksheet_Row;
use arogachev\excel\import\exceptions\RowException;

class Model extends BaseModel
{
    const EVENT_INIT = 'init';

    /**
     * @var PHPExcel_Worksheet_Row
     */
    public $row;

    /**
     * @inheritdoc
     */
    protected static $attributeClassName = 'codexten\yii\web\widgets\importer\Attribute';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->trigger(self::EVENT_INIT);
    }

    protected function initAttributes()
    {
        $sheet = $this->row->getCellIterator()->current()->getWorksheet();

        foreach ($this->_standardModel->standardAttributes as $standardAttribute) {
            if ($standardAttribute->column) {
                $this->initAttribute([
                    'standardAttribute' => $standardAttribute,
                    'cell' => $sheet->getCell($standardAttribute->column . $this->row->getRowIndex()),
                ]);
            }
        }
    }

    public function load()
    {
        $this->loadExisting();
        $this->assignMassively();
    }

    protected function loadExisting()
    {
        if ($this->isPkEmpty()) {
            return;
        }

        /* @var $modelClass \yii\db\ActiveRecord */
        $modelClass = $this->_standardModel->className;
        $model = $modelClass::findOne($this->getPkValues());
        if ($model) {
            $this->_instance = $model;
        }
    }

    /**
     * @return Attribute[]
     */
    protected function getPk()
    {
        $attributes = [];
        foreach ($this->_attributes as $attribute) {
            if (in_array($attribute->standardAttribute->name, $this->_instance->primaryKey())) {
                $attributes[] = $attribute;
            }
        }

        return $attributes;
    }

    /**
     * @return array
     */
    protected function getPkValues()
    {
        $values = [];
        foreach ($this->getPk() as $attribute) {
            $values[$attribute->standardAttribute->name] = $attribute->value;
        }

        return $values;
    }

    /**
     * @return boolean
     */
    protected function isPkEmpty()
    {
        foreach ($this->getPkValues() as $value) {
            if ($value) {
                return false;
            }
        }

        return true;
    }

    protected function assignMassively()
    {
        foreach ($this->_attributes as $attribute) {
            $this->_instance->{$attribute->standardAttribute->name} = $attribute->value;
        }
    }

    /**
     * @param boolean $runValidation
     * @throws RowException
     */
    public function save($runValidation = true)
    {
        if ($runValidation) {
            $this->validate();
        }

        $this->_instance->save(false);
    }

    public function validate()
    {
        if (!$this->_instance->validate()) {
            DI::getImporter()->wrongModel = $this->_instance;

            foreach ($this->_instance->errors as $error => $message) {

                Importer::addError($this->row->getRowIndex(), $message, $error);

            }

        }
    }

}

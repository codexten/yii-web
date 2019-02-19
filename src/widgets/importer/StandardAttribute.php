<?php

namespace codexten\yii\web\widgets\importer;

use codexten\yii\web\widgets\importer\components\StandardAttribute as BaseStandardAttribute;
use arogachev\excel\exceptions\StandardAttributeException;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * @property StandardModel $standardModel
 */
class StandardAttribute extends BaseStandardAttribute
{
    /**
     * @inheritdoc
     */
    protected function validateName()
    {
        parent::validateName();

        $standardModel = $this->_standardModel;
        $model = $standardModel->instance;

        if (!in_array($this->name, $model->attributes())) {
            throw new StandardAttributeException($this, 'Attribute not exist.');
        }

        if (in_array($this->name, $model->primaryKey())) {
            return;
        }

        if (in_array($this->name, ArrayHelper::getColumn($standardModel->standardAttributesConfig, 'name'))) {
            return;
        }

        if (!$model->isAttributeSafe($this->name)) {
            throw new StandardAttributeException($this, 'Attribute is not allowed for import.');
        }
    }
}

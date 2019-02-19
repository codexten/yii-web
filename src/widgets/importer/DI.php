<?php

namespace codexten\yii\web\widgets\importer;

use arogachev\excel\import\advanced\Importer as AdvancedImporter;
use codexten\yii\web\widgets\importer\Importer as BasicImporter;
use PHPExcel;
use Yii;

class DI
{
    /**
     * @return BasicImporter|AdvancedImporter
     * @throws \yii\base\InvalidConfigException
     */
    public static function getImporter()
    {
        return Yii::$container->get('importer');
    }

    /**
     * @param BaseImporter $value
     */
    public static function setImporter($value)
    {
        Yii::$container->set('importer', $value);
    }

    /**
     * @return PHPExcel
     * @throws \yii\base\InvalidConfigException
     */
    public static function getPHPExcel()
    {
        return static::getImporter()->phpExcel;
    }

    /**
     * @return CellParser
     * @throws \yii\base\InvalidConfigException
     */
    public static function getCellParser()
    {
        return static::getImporter()->cellParser;
    }
}

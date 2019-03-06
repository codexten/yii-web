<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 */

namespace codexten\yii\web\widgets;

use entero\helpers\ArrayHelper;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

/**
 * Class FileUploadWidget
 *
 * @package codexten\yii\web\widgets
 * @author Sreenath Sahadevan <sreenath@entero.in>
 * @author Jomon Johnson <jomonjohnson.dev@gmail.com>
 */
class FileUploadWidget extends Upload
{
    /**
     * @var file
     */
    const FILE_TYPE_FILE = 'file';
    const FILE_TYPE_IMAGE = 'image';
    const FILE_TYPE_ANY = 'any';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        $this->url = $this->url ?: ['upload'];
        $this->maxFileSize = $this->maxFileSize ?: 15 * 1024 * 1024; // 15.7 MiB
        $this->acceptFileTypes = $this->acceptFileTypes ?: self::FILE_TYPE_IMAGE;
        $fileExtensions = self::fileTypes($this->acceptFileTypes);
        $this->acceptFileTypes = new JsExpression('/(\.|\/)(' . implode('|', $fileExtensions) . ')$/i');
        parent::init();
    }

    /**
     * @param $code
     *
     * @return mixed
     */
    public static function fileTypes($code)
    {
        $all = [
            self::FILE_TYPE_FILE => ['pdf', 'doc', 'docx', 'ods', 'txt'],
            self::FILE_TYPE_IMAGE => ['gif', 'jpe?g', 'png'],
            self::FILE_TYPE_ANY => ['.*'],
        ];

        return ArrayHelper::getValue($all, $code, null);
    }
}
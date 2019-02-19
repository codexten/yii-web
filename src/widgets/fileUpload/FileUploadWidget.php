<?php

namespace codexten\yii\web\widgets\fileUpload;

use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

class FileUploadWidget extends Upload
{
    const TYPE_FILE = 'file';
    const TYPE_IMAGE = 'image';
    const TYPE_ANY = 'any';

    public $url = ['/file-storage/upload'];
    public $maxFileSize = 15 * 1024 * 1024;// 15.7 MiB
    public $fileType = false;

    public function init()
    {
        $this->setAcceptFileTypes();
        parent::init();
    }

    protected function setAcceptFileTypes()
    {
        $all = [
            static::TYPE_IMAGE => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
            static::TYPE_FILE => new JsExpression('/(\.|\/)(pdf|doc|docx|ods|txt|)$/i'),
            static ::TYPE_ANY => new JsExpression('/(\.|\/)()$/i'),
        ];

        $this->acceptFileTypes = $this->fileType ? $all[$this->fileType] : $this->acceptFileTypes;
    }


}
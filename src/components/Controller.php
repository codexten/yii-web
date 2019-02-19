<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 9/21/18
 * Time: 9:19 PM
 */

namespace codexten\yii\web\components;

use InvalidArgumentException;
use Yii;

class Controller extends \yii\web\Controller
{
    /**
     * @var string the root directory of the module.
     */
    private $_basePath;

    /**
     * Returns the root directory of the module.
     * It defaults to the directory containing the module class file.
     *
     * @return string
     * @throws \ReflectionException
     */
    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $class = new \ReflectionClass($this);
            $this->_basePath = Yii::getAlias('@' . str_replace('\\', '/', $class->getNamespaceName()));
        }

        return $this->_basePath;
    }

    /**
     * Sets the root directory of the module.
     * This method can only be invoked at the beginning of the constructor.
     *
     * @param string $path the root directory of the module. This can be either a directory name or a [path alias](guide:concept-aliases).
     *
     * @throws InvalidArgumentException if the directory does not exist.
     */
    public function setBasePath($path)
    {
        $path = Yii::getAlias($path);
        $p = strncmp($path, 'phar://', 7) === 0 ? $path : realpath($path);
        if ($p !== false && is_dir($p)) {
            $this->_basePath = $p;
        } else {
            throw new InvalidArgumentException("The directory does not exist: $path");
        }
    }


    public function getViewPath()
    {
        $viewFolder = str_replace('controllers', 'views', $this->getBasePath()) . DIRECTORY_SEPARATOR . $this->id;

        if (file_exists($viewFolder)) {
            return $viewFolder;
        }

        return parent::getViewPath();
    }
}
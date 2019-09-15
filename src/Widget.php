<?php

namespace codexten\yii\web;

use BadMethodCallException;
use Kir\StringUtils\Matching\Wildcards\Pattern;
use ReflectionClass;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\View;

class Widget extends \yii\base\Widget
{
    /**
     * @var string
     */
    public $layout = 'default';
    /**
     * @var object original view context.
     * It is used to render sub-views with the same context, as IndexPage
     */
    public $originalContext;
    /**
     * @var array Hash of document blocks, that can be rendered later in the widget's views
     * Blocks can be set explicitly on widget initialisation, or by calling [[beginContent]] and
     * [[endContent]]
     *
     * @see beginContent
     * @see endContent
     */
    public $contents = [];
    /**
     * @var string the name of current content block, that is under the render
     * @see beginContent
     * @see endContent
     */
    private $_current = null;
    protected $templates = [];

    public function __construct(array $config = [])
    {
        Yii::configure($this, $this->defaultConfig());
//        $config = ArrayHelper::merge($this->defaultConfig(), $config);
        parent::__construct($config);
    }


    protected function defaultConfig()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->originalContext = Yii::$app->view->context;
    }

    protected function loadTemplates()
    {
        $templates = [];
        foreach ($this->templates as $template) {
            $templates[$template] = $this->renderTemplate($template);
        }
        $this->contents['templates'] = "\n" . implode("", $templates) . "\n" .ArrayHelper::getValue( $this->contents,'templates','');
    }

    /**
     * @param $template
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function renderTemplate($template)
    {
        $template = Inflector::id2camel($template);

        return $this->render('_template' . $template);
    }

    /**
     * Begins output buffer capture to save data in [[contents]] with the $name key.
     * Must not be called nested. See [[endContent]] for capture terminating.
     *
     * @param string $name
     */
    public function beginContent($name)
    {
        if ($this->_current) {
            throw new BadMethodCallException('Output buffer capture is already running for ' . $this->_current);
        }
        $this->_current = $name;
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * Terminates output buffer capture started by [[beginContent()]].
     *
     * @see beginContent
     */
    public function endContent()
    {
        if (!$this->_current) {
            throw new BadMethodCallException('Outout buffer capture is not running. Call beginContent() first');
        }
        $this->contents[$this->_current] = ob_get_contents();
        ob_end_clean();
        $this->_current = null;
    }

    /**
     * Returns content saved in [[content]] by $name.
     *
     * @param string $name
     * @param Widget|boolean $from
     *
     * @return string
     */
    public function renderContent($name, &$from = false)
    {
        if ($from) {
            foreach ($this->contents as $key => $value) {
                if (Pattern::create($name)->match($key)) {
                    unset($this->contents[$key]);
                    $key = explode('.', $key);
                    $key = $key[1];
                    $from->contents[$key] = $value;

                    return;
                }
            }

        }

        return $this->contents[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->loadTemplates();

        return $this->render($this->layout);
    }

    protected function defineJsVariable($varibale, $value)
    {
        $value = Json::encode($value);
        $this->view->registerJs("window.{$varibale} = {$value};", View::POS_HEAD);
    }

    /**
     * {@inheritdoc}
     */
    public function getViewPath()
    {
        return '@app/widgets/views';
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function render($view, $params = [])
    {
        $params = ArrayHelper::merge(['widget' => $this], $params);
        $class = new ReflectionClass($this);
        $folder = Inflector::camel2id($class->getShortName());
        $view = $folder . '/' . $view;

        return $this->getView()->render($view, $params, $this);
    }
}
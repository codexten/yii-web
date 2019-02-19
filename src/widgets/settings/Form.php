<?php

namespace codexten\yii\web\widgets\settings;

use enyii\base\Model;
use enyii\base\Widget;
use enyii\components\Settings;
use enyii\helpers\ArrayHelper;
use enyii\helpers\Html;
use enyii\helpers\Inflector;
use enyii\helpers\Url;
use entero\te\core\metronic\widgets\Nav;
use yii\bootstrap\ActiveField;

class Form extends Widget
{

    public $fieldDefaultConfig = [];

    //input types
    const INPUT_TYPE_TEXT = 'text';
    const INPUT_TYPE_TEXT_AREA = 'textArea';
    const INPUT_TYPE_DROP_DOWN_LIST = 'dropDownList';
    const INPUT_TYPE_RADIO = 'radio';
    const INPUT_TYPE_CHECKBOX = 'checkbox';
    const INPUT_TYPE_CHECKBOX_LIST = 'checkboxList';
    const INPUT_TYPE_LIST_BOX = 'listBox';
    const INPUT_TYPE_WIDGET = 'widget';
    const INPUT_TYPE_FILE = 'file';
    const INPUT_TYPE_HTML_BLOCK = 'htmlBlock';
    const INPUT_TYPE_JS_BLOCK = 'jsBlock';
    const INPUT_TYPE_CSS_BLOCK = 'cssBlock';
    const INPUT_TYPE_PHP_BLOCK = 'phpBlock';
    const INPUT_TYPE_TYPEAHEAD = 'typeahead';
    const INPUT_TYPE_SELECT2 = 'select2';
    const INPUT_TYPE_UPLOAD_WIDGET = 'uploadWidget';
    const INPUT_TYPE_IMAGE_UPLOAD_WIDGET = 'imageUploadWidget';
    const INPUT_TYPE_TAG = 'tag';
    const INPUT_TYPE_DATE = 'date';
    const INPUT_TYPE_DATE_TIME = 'dateTime';
    const INPUT_SWITCH = 'switch';
    const INPUT_REDACTOR = 'redactor';


    const ACTION_HIDE = 'hide';
    const ACTION_SHOW = 'show';


    /**
     * @var Model[]
     */
    public $models = false;
    /**
     * @var Settings
     */
    public $settings;

    public $wrapperConfig = [
        'tag' => 'div',
        'options' => ['class' => 'tabbable-line boxless tabbable-reversed'],
    ];

    public $tabContainerConfig = [
        'tag' => 'div',
        'options' => ['class' => 'tab-content'],
    ];

    public $tabConfig = [
        'tag' => 'div',
        'options' => ['class' => 'tab-pane'],
    ];

    public $rowConfig = [
        'tag' => 'div',
        'options' => ['class' => 'row'],
    ];

    public $columnConfig = [
        'tag' => 'div',
        'options' => ['class' => 'col-md-6'],
    ];

    public $navConfig = [
        'options' => ['class' => 'nav nav-tabs'],
    ];

    public $tabItemOptions = ['data-toggle' => 'tab'];

    public $columnOptions = ['class' => 'col-md-6'];

    //public properties
    public $formClass = 'codexten\yii\web\widgets\ActiveForm';
    public $formConfig = [];
    public $configFile;
    /**
     * @var ActiveForm
     */
    public $form = false;

    private $_isMultiple;


    public function __construct(array $config = [])
    {
        $this->setFieldDefaultConfig();
        parent::__construct($config);
    }

    public function init()
    {
        $this->_isMultiple = !($this->form == false);
        parent::init();
    }


    protected function setFieldDefaultConfig()
    {
        $this->fieldDefaultConfig = [
            static::INPUT_TYPE_UPLOAD_WIDGET => [

            ]
        ];
    }


    protected function defaultConfig()
    {
        return [
            'formConfig' => [
                'layout' => 'horizontal',
            ],
        ];
    }

    public function run()
    {
        if (!$this->_isMultiple) {
            $this->beginForm();
        }
        $this->beginWrapper();
        $this->renderNav($this->getTabItems());
        $this->renderTabContents();
        $this->endWrapper();
        if (!$this->_isMultiple) {
            $this->endForm();
        }
    }

    private function beginWrapper()
    {
        echo Html::beginTag($this->wrapperConfig['tag'], $this->wrapperConfig['options']);
    }

    private function endWrapper()
    {
        echo Html::endTag($this->wrapperConfig['tag']);
    }

    private function renderNav($items, $config = [])
    {
        $config = ArrayHelper::merge($this->navConfig, $config);
        $config['items'] = $items;
        echo Nav::widget($config);
    }

    private function renderTabContents()
    {
        echo Html::beginTag($this->tabContainerConfig['tag'], $this->tabContainerConfig['options']);
        $class = 'active';
        foreach ($this->settings->config['tabs'] as $tab) {
            $tab['options']['class'] = $this->tabConfig['options']['class'] . ' ' . $class;
            $this->renderTab($tab);
            $class = '';
        }
        echo Html::endTag($this->tabContainerConfig['tag']);
    }

    public function renderTab($data)
    {
        $options = ArrayHelper::merge($this->tabConfig['options'], $data['options']);
        $options['id'] = $this->getTabId($data['label']);
        echo Html::beginTag($this->tabConfig['tag'], $options);
        echo $this->renderHelpBlock(ArrayHelper::getValue($data, 'help'));
        echo Html::beginTag($this->rowConfig['tag'], $this->rowConfig['options']);
        foreach (ArrayHelper::getValue($data, 'columns', []) as $column) {
            if (ArrayHelper::getValue($column, 'newRow')) {
                echo Html::endTag($this->rowConfig['tag']);
                echo Html::beginTag($this->rowConfig['tag'], $this->rowConfig['options']);
            }
            $this->renderColumn($column);
        }
        echo Html::endTag($this->rowConfig['tag']);
        echo Html::endTag($this->tabConfig['tag']);
    }


    protected function renderHelpBlock($html)
    {
        if (!$html) {
            return false;
        }

        return $this->view->renderFile(__DIR__ . '/views/help.php', ['html' => $html]);
    }

    public function renderColumn($data)
    {
        $config = ArrayHelper::getValue($data, 'config', []);
        $config = ArrayHelper::merge($this->columnConfig, $config);
        echo Html::beginTag($config['tag'], $config['options']);
        if ($label = ArrayHelper::getValue($data, 'label')) {
            echo Html::beginTag('fieldset');
            echo Html::tag('legend', $label);
        }
        foreach (ArrayHelper::getValue($data, 'fields', []) as $field) {
            $this->renderField($field);
        }
        if ($label) {
            echo Html::endTag('fieldset');
        }
        echo Html::endTag($this->columnConfig['tag']);
    }

    private function getTabId($label)
    {
        return 'tab_' . Inflector::slug($label);
    }

    public function getTabItems()
    {
        $items = [];
        $class = 'active';
        foreach ($this->settings->config['tabs'] as $item) {
            $items[] = [
                'label' => $item['label'],
                'url' => '#' . $this->getTabId($item['label']),
                'linkOptions' => $this->tabItemOptions,
                'options' => ['class' => $class]
            ];
            $class = '';
        }

        return $items;
    }

    protected function renderField($field)
    {
        $field = $this->normalizeField($field);
        $inputType = ArrayHelper::getValue($field, 'inputType');
        $model = $this->models[$field['key']];
        echo $this->renderFile(__DIR__ . "/fields/{$inputType}.php", [
            'form' => $this->form,
            'model' => $model,
            'key' => $field['key'],
            'hint' => $field['hint'],
            'label' => $field['label'],
            'config' => $field['config'],
            'options' => $field['options'],
        ]);

        if (ArrayHelper::getValue($field, 'dependency')) {
            $this->registerDependency($field);
        }
    }

    protected function normalizeField($field)
    {
        $field['hint'] = ArrayHelper::getValue($field, 'hint', '');
        $field['config'] = ArrayHelper::getValue($field, 'config', []);
        $field['options'] = ArrayHelper::getValue($field, 'options', []);
        $field['config']['options'] = ArrayHelper::getValue($field['config'], 'options', []);

        $normalizeFunction = 'normalize' . Inflector::camelize($field['inputType']);

        if ($this->hasMethod($normalizeFunction)) {
            $field['config'] = $this->{$normalizeFunction}($field);
        }

        return $field;
    }

    protected function normalizeDropDownList($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);
        $config['options'] = ArrayHelper::merge([
            'prompt' => '',
        ], $options);

        return $config;
    }

    protected function normalizeJsBlock($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);
        $config['options'] = ArrayHelper::merge([
            'mode' => 'js',
            'theme' => 'github',
        ], $options);

        return $config;
    }

    protected function normalizeCssBlock($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);
        $config['options'] = ArrayHelper::merge([
            'mode' => 'css',
            'theme' => 'github',
        ], $options);

        return $config;
    }

    protected function normalizePhpBlock($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);
        $config['options'] = ArrayHelper::merge([
            'mode' => 'php',
            'theme' => 'github',
        ], $options);

        return $config;
    }

    protected function normalizeImageUploadWidget($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);

        $config['options'] = ArrayHelper::merge([
            'uploadUrl' => Url::toRoute('upload-photo'),
            'width' => 400,
            'height' => 500,
        ], $options);

        return $config;
    }

    protected function normalizeUploadWidget($field)
    {
        $config = ArrayHelper::merge(ArrayHelper::getValue($this->fieldDefaultConfig,
            static::INPUT_TYPE_UPLOAD_WIDGET), $field['config']);

        $options = ArrayHelper::getValue($config, 'options', []);

        $config['options'] = ArrayHelper::merge($options, $options);

        return $config;
    }

    protected function normalizeHtmlBlock($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);
        $config['options'] = ArrayHelper::merge([
            'mode' => 'html',
            'theme' => 'github',
        ], $options);

        return $config;
    }

    protected function normalizeRedactor($field)
    {
        $config = $field['config'];

        $options = ArrayHelper::getValue($config, 'options', []);
        $config['options'] = ArrayHelper::merge([
            'plugins' => [],
            'options' => [
                'minHeight' => 500,
                'maxHeight' => 500,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
            ]
        ], $options);

        return $config;
    }

    protected function beginGroup($groupName)
    {
        echo Html::beginTag('fieldset');
        echo Html::tag('legend', $groupName);
    }

    protected function endGroup()
    {
        echo Html::endTag('fieldset');
    }

    protected function beginForm()
    {
        $this->form = call_user_func("{$this->formClass}::begin", $this->formConfig);
    }

    protected function endForm()
    {
        call_user_func("{$this->formClass}::end");
    }


    public function getInputId($key)
    {
        $model = $this->models[$key];

        return Html::getInputId($model, "[{$key}]value");
    }

    protected function registerDependency($field)
    {
        $inputId = $this->getInputId($field['key']);


        foreach ($field['dependency'] as $dependency) {
            $selectors = [];
            foreach (ArrayHelper::getValue($dependency, 'keys', []) as $key) {
                $selectors[] = '.field-' . $this->getInputId($key);
            }
            $selectors = ArrayHelper::merge($selectors, ArrayHelper::getValue($dependency, 'selectors', []));
            $action = $this->getAction($dependency['action']);
            $value = $dependency['value'];
            $selectors = implode($selectors, ',');

            $js = <<<JS
$("#{$inputId}").change(function() {
    console.log($(this).val());
  if($(this).val() == '{$value}' ){
   $("{$selectors}").{$action};
  }
});
JS;

            $this->view->registerJs($js);
        }
    }

    public function getAction($code)
    {
        $all = [
            static::ACTION_SHOW => 'show()',
            static::ACTION_HIDE => 'hide()',
        ];

        return $all[$code];
    }


}
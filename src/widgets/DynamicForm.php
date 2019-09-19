<?php

namespace codexten\yii\web\widgets;

use enyii\base\Model;
use enyii\base\Widget;
use enyii\db\ActiveRecord;
use enyii\helpers\Inflector;
use enyii\helpers\Json;
use enyii\web\EnyiiAsset;
use yii\base\InvalidParamException;
use yii\web\ForbiddenHttpException;

/**
 *
 * This is the widget for DynamicForm. to render same fields for many times while clicking on the plus button.
 *
 * $formId = '<current-form-name>; //define at the start of the page.
 *
 * it should call inside the form.
 * the whole form must inside a div tag having id <?= $formId ?>-wrapper.
 *
 *```php
 * use codexten\yii\web\widgets\DynamicForm;
 *
 *   <?php DynamicForm::begin([
 *      'relationModelClass' => OptionValue::class, //the model used in foreach. here `$model->optionsValues` ,ie OptionsValues is the model.
 *      'formId' => $formId,// id of the current form
 *      'addButtonId' => 'addButton',//add button id
 *      'removeButtonClass' => 'remove-btns', //remove button class
 *      'url' => Url::to(['create', 'formUpdate' => true]), // url to the action
 *      'loopDivId' = 'loop', //div ID inside the foreach loop.
 *      ]); ?>
 *
 * //render your field in foreach loop
 *   <?php foreach ($model->optionsValues as $index => $optionsValue): ?>
 *
 *      <div id="loop"> this will be taken as the loopDivId property.
 *
 *          //render your fields inside this div.
 *
 *      </div>
 *
 * <?php endforeach; ?>
 *
 * //remove button. the remove button should be inside the foreach loop.
 *  <?= Html::a(Yii::t('backend', '{icon}',
 *          ['icon' => '<i class="fa fa-minus fa-fw"></i>']),// icon for the minus button
 *          'javascript:;',//url section. the url must be the same as given here.
 *          [
 *              'class' => 'btn btn-danger btn-xs pull-right remove-btns', // here the "remove-btns" class is the 'removeButtonClass' property in the configuration.
 *          ])
 *  ?>
 *
 * //add button
 *  <?= Html::a(Yii::t('backend', '{icon}',
 *      ['icon' => '<i class="fa fa-plus fa-fw"></i>']),//icon for plus button
 *      'javascript:;', //url. this url should be 'javascript:;'.
 *      [
 *      'class' => 'btn btn-success btn-xs pull-right',
 *      'id' => 'addButton' //id for the add button in configuration(addButton).
 *      ])
 *  ?>
 *
 * <?php DynamicForm::end();?>
 *
 *```
 * Class DynamicForm
 * @package codexten\yii\web\widgets
 * @author Ajith Lal <ajithlal@entero.in>
 */
class DynamicForm extends Widget
{
    /**
     * @var string model. The related model ( model used in foreach )
     */
    public $relationModelClass;
    /**
     * @var string addButtonId. The ID property of the add button.
     */
    public $addButtonId;
    /**
     * @var string removeButtonClass. The class property of the Remove button.
     */
    public $removeButtonClass;
    /**
     * @var string class. the class for the div tag.
     */
    public $class;
    /**
     * @var string url. URL to the action with parameters.
     */
    public $url;
    /**
     * @var string formId. the id of the current form.
     */
    public $formId;
    /**
     * @var string $loopDivId . the ID for the dive inside the foreach loop.
     */
    public $loopDivId;
    /**
     * @var array _addButtonConfig. to create the configuration option for the add button.
     */
    private $_addButtonConfig = [];
    private $_relationName;
    private $_inputName;

    /**
     * Initializing the fields. and checking the required fields are empty or not.
     *
     * if the required fields are empty then, @throws ForbiddenHttpException
     * @throws InvalidParamException
     */
    public function init()
    {
        parent::init();
        if (empty($this->relationModelClass)) {
            throw new ForbiddenHttpException('The model property must be set.');
        }
        if (empty($this->addButtonId)) {
            throw new ForbiddenHttpException('The addButton property must be set.');
        }
        if (empty($this->url)) {
            throw new ForbiddenHttpException('The url property must be set or it should be an array.');
        }
        if (empty($this->removeButtonClass)) {
            throw new ForbiddenHttpException('The removeButtonClass property must be set or it should be an array.');
        }
        if (empty($this->formId)) {
            throw new ForbiddenHttpException('The formId property must be set.');
        }
        if (empty($this->loopDivId)) {
            throw new ForbiddenHttpException('The formId property must be set.');
        }

        $this->_relationName = explode('\\', $this->relationModelClass);
        $this->_relationName = Inflector::pluralize(lcfirst($this->_relationName[3]));

        $this->_inputName = explode('\\', $this->relationModelClass);
        $this->_inputName = $this->_inputName[3];

        $this->_addButtonConfig = Json::encode([
            'action' => 'add',
            'relationName' => $this->_relationName,
            'inputName' => $this->_inputName
        ]);

        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $content = ob_get_clean();
        $this->registerScript();
        echo $content;
    }

    /**
     * Registers the needed assets.
     *
     */
    protected function registerScript()
    {
        $view = $this->getView();
        EnyiiAsset::register($view);

        //add button click event
        $js = "$('#{$this->addButtonId}').on('click',function(){
            dynamicFieldUpdate('#{$this->formId}-wrapper','{$this->url}','{$this->_addButtonConfig}')});";
        $view->registerJs($js, $view::POS_READY);

        //remove button click event
        $js = "$('.{$this->removeButtonClass}').on('click',function(){
        var currentID =$(this).parents('#{$this->loopDivId}').find(\"input\").attr('id');
        var index = currentID.split('-');
        var index = index[1];
        dynamicFieldUpdate('#{$this->formId}-wrapper','{$this->url}','{\"action\":\"remove\",\"relationName\":\"{$this->_relationName}\",\"inputName\":\"{$this->_inputName}\",\"removeIndex\":\"'+index+'\"}')});";
        $view->registerJs($js, $view::POS_READY);
    }
}

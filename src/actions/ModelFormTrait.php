<?php

namespace codexten\yii\web\actions;

use yii\base\Model;
use yii\widgets\ActiveForm;

/**
 * ModelFormTrait provides basic functionality for the actions, which handles model input collection from web form.
 * This trait should be used inside the descendant of [[Action]] class.
 *
 */
trait ModelFormTrait
{
    /**
     * @var string the scenario to be assigned to the new model before it is validated and saved.
     */
    public $scenario = Model::SCENARIO_DEFAULT;

    /**
     * Populates the model with input data.
     *
     * @param Model $model model instance.
     * @param array $data the data array to load, typically `$_POST` or `$_GET`.
     *
     * @return boolean whether expected forms are found in `$data`.
     */
    protected function load($model, $data)
    {
        /* @var $this Action */
        $event = new ActionEvent($this, [
            'model' => $model,
            'result' => $model->load($data),
        ]);
        $this->trigger('afterDataLoad', $event);

        return $event->result;
    }

    /**
     * Performs AJAX validation of the model via [[ActiveForm::validate()]].
     *
     * @param Model $model main model.
     *
     * @return array the error message array indexed by the attribute IDs.
     */
    protected function performAjaxValidation($model)
    {
        /* @var $this Action */
        $event = new ActionEvent($this, [
            'model' => $model,
            'result' => ActiveForm::validate($model),
        ]);

        $this->trigger('afterAjaxValidate', $event);

        return $event->result;
    }
}
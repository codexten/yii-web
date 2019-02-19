<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:20 PM
 */

namespace codexten\yii\web\actions;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\web\Response;

class CreateAction extends Action
{
    use ModelFormTrait;

    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'create';

    /**
     * @var callable a PHP callable that will be called to create the new model.
     * If not set, [[newModel()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return the new model instance.
     */
    public $newModel;

    /**
     * @var boolean|callable provides control for model default values populating.
     * If set to `false` - no default value population will be performed.
     * If set to `true` - it will invoke `loadDefaultValues()` method on model.
     * You can set this as a callable of following signature:
     *
     * ```php
     * function ($model) {
     *     // populate default values.
     * }
     * ```
     */
    public $loadDefaultValues = false;

    /**
     * Creates new model instance.
     *
     * @return ActiveRecordInterface|Model new model instance.
     */
    public function newModel()
    {
        if ($this->newModel !== null) {
            return call_user_func($this->newModel, $this);
        }
        if ($this->controller->hasMethod('newModel')) {
            return call_user_func([$this->controller, 'newModel'], $this);
        }

        return new $this->modelClass();
    }

    /**
     * Creates new record.
     *
     * @return array|string|\yii\web\Response
     */
    public function run()
    {
        $model = $this->newModel();
        $model->scenario = $this->scenario;
        $this->loadModelDefaultValues($model);

        if ($this->load($model, Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return $this->performAjaxValidation($model);
            }
            if ($model->save()) {
                $this->setFlash($this->getSuccessMessage(), ['model' => $model]);

                return $this->redirect($this->createReturnUrl('view', $model));
            }
        }

        return $this->render($this->view, [
            'model' => $model,
        ]);
    }

    /**
     * Populates given model with the default values.
     *
     * @param Model $model model to be processed.
     */
    protected function loadModelDefaultValues($model)
    {
        if ($this->loadDefaultValues === false) {
            return;
        }
        if ($this->loadDefaultValues === true) {
            $model->loadDefaultValues();
        } else {
            call_user_func($this->loadDefaultValues, $model);
        }
    }
}
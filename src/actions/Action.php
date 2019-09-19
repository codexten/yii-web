<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:18 PM
 */

namespace codexten\yii\web\actions;

use codexten\yii\web\CrudController;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class Action
 *
 * @package codexten\yii\web\actions
 */
class Action extends \yii\rest\Action
{
    use ActionTrait;

    public $layout;

    /**
     * @var CrudController
     */
    public $controller;

    /**
     * @var callable a PHP callable that will be called to return the model corresponding
     * to the specified primary key value. If not set, [[findModel()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($id, $action) {
     *     // $id is the primary key value. If composite primary key, the key values
     *     // will be separated by comma.
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return the model found, or throw an exception if not found.
     */
    public $findModel;
    /**
     * @var string ID of the controller action, which user should be redirected to on success.
     * This property overrides the value set by [[setReturnAction()]] method.
     * @see getReturnAction()
     * @see returnUrl
     */
    public $returnAction;
    /**
     * @var string|array|callable URL, which user should be redirected to on success.
     * This could be a plain string URL, URL array configuration or callable, which returns actual URL.
     * The signature for the callable is following:
     *
     * ```
     * string|array function (Model $model) {}
     * ```
     *
     * Note: actual list of the callable arguments may vary depending on particular action class.
     *
     * Note: this option takes precedence over [[returnAction]] related logic.
     *
     * @see returnAction
     */
    public $returnUrl;

    public $messages = [];


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if ($this->view === null) {
            $this->view = $this->id;
        }

        parent::init();
    }

    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     *
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     *
     * @return ActiveRecordInterface|Model the model found
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if ($this->findModel !== null) {
            return call_user_func($this->findModel, $id, $this);
        } elseif ($this->controller->hasMethod('findModel')) {
            return call_user_func([$this->controller, 'findModel'], $id, $this);
        }
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');

//        throw new InvalidConfigException('Either "' . get_class($this) . '::$findModel" must be set or controller must declare method "findModel()".');
    }

    /**
     * Checks whether action with specified ID exists in owner controller.
     *
     * @param string $id action ID.
     *
     * @return boolean whether action exists or not.
     */
    public function actionExists($id)
    {
        $inlineActionMethodName = 'action' . Inflector::camelize($id);
        if (method_exists($this->controller, $inlineActionMethodName)) {
            return true;
        }
        if (array_key_exists($id, $this->controller->actions())) {
            return true;
        }

        return false;
    }

    /**
     * Sets the return action ID.
     *
     * @param string|null $actionId action ID, if not set current action will be used.
     */
    public function setReturnAction($actionId = null)
    {
        if ($actionId === null) {
            $actionId = $this->id;
        }
        if (strpos($actionId, '/') === false) {
            $actionId = $this->controller->getUniqueId() . '/' . $actionId;
        }
        $sessionKey = '__adminReturnAction';
        Yii::$app->getSession()->set($sessionKey, $actionId);
    }

    /**
     * Returns the ID of action, which should be used for return redirect.
     * If action belongs to another controller or does not exist in current controller - 'index' is returned.
     *
     * @param string $defaultActionId default action ID.
     *
     * @return string action ID.
     */
    public function getReturnAction($defaultActionId = 'index')
    {
        if ($this->returnAction !== null) {
            return $this->returnAction;
        }

        $sessionKey = '__adminReturnAction';
        $actionId = Yii::$app->getSession()->get($sessionKey, $defaultActionId);
        $actionId = trim($actionId, '/');
        if ($actionId === 'index') {
            return $actionId;
        }

        if (strpos($actionId, '/') !== false) {
            $controllerId = StringHelper::dirname($actionId);
            if ($controllerId !== $this->controller->getUniqueId()) {
                return 'index';
            }
            $actionId = StringHelper::basename($actionId);
        }

        if (!$this->actionExists($actionId)) {
            return 'index';
        }

        return $actionId;
    }

    /**
     * @param string $defaultActionId default action ID.
     * @param ActiveRecordInterface|Model|null $model model being processed by action.
     *
     * @return array|string URL
     */
    public function createReturnUrl($defaultActionId = 'index', $model = null)
    {
        if ($this->returnUrl !== null) {
            if (is_string($this->returnUrl)) {
                return $this->returnUrl;
            }
            if (!is_callable($this->returnUrl, true)) {
                return $this->returnUrl;
            }

            $args = func_get_args();
            array_shift($args);

            return call_user_func_array($this->returnUrl, $args);
        }

        $actionId = $this->getReturnAction($defaultActionId);
        $queryParams = Yii::$app->request->getQueryParams();
        unset($queryParams['id']);
        $url = array_merge(
            [$actionId],
            $queryParams
        );
        if (is_object($model) && in_array($actionId, ['view', 'update'], true)) {
            $url = array_merge(
                $url,
                ['id' => implode(',', array_values($model->getPrimaryKey(true)))]
            );
        }

        return $url;
    }

    protected function getSuccessMessage()
    {
        return $this->getMessage('success');
    }

    protected function getMessage($key)
    {
        $message = $this->messages[$key];

        if (is_callable($message)) {
            return call_user_func($message);
        }

        return $message;
    }

    public function setFlash($message, $params = [])
    {
        Yii::$app->getSession()->setFlash('success', $message);
    }

//    /**
//     * @return string
//     */
//    public function run()
//    {
//        return $this->controller->render($this->view ?: $this->id);
//    }

    /**
     * @param $url
     * @param null $statusCode
     *
     * @return Response
     */
    public function redirect($url, $statusCode = null)
    {
        return $this->controller->redirect($url, $statusCode);
    }
}

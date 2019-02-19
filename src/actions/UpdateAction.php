<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:19 PM
 */

namespace codexten\yii\web\actions;

use Yii;
use yii\web\Response;

class UpdateAction extends ModelAction
{
    use ModelFormTrait;

    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'update';

    /**
     * Updates existing record specified by id.
     *
     * @param mixed $id id of the model to be deleted.
     *
     * @return mixed response.
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $this->scenario;

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
}
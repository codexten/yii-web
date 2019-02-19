<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:19 PM
 */

namespace codexten\yii\web\actions;


use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

class DeleteAction extends \yii\rest\DeleteAction
{

    /**
     * @param mixed $id
     *
     * @throws ServerErrorHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
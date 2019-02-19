<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:20 PM
 */

namespace codexten\yii\web\actions;

use yii\web\NotFoundHttpException;

class ViewAction extends Action
{
    public function run()
    {
        $id = \Yii::$app->request->get('id');
        $model = $this->findModel($id);
        if (!$model->canView()) {
            throw new NotFoundHttpException();
        }

        return $this->controller->render('view', ['model' => $model]);
    }
}
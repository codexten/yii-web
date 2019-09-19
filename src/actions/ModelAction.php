<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 13/1/19
 * Time: 5:32 PM
 */

namespace codexten\yii\web\actions;

class ModelAction extends Action
{
    public $perform;

    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->perform($model)) {
            $this->setFlash($this->getSuccessMessage(), ['model' => $model]);

            return $this->redirect($this->createReturnUrl('view', $model));
        }

        return $this->render($this->view);
    }

    protected function perform($model)
    {
        if ($this->perform !== null) {
            return call_user_func($this->perform, $model);
        }

        return false;
    }
}
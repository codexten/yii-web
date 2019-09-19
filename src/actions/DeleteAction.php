<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 2/10/18
 * Time: 5:19 PM
 */

namespace codexten\yii\web\actions;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\web\ServerErrorHttpException;
use yii\helpers\ArrayHelper;

class DeleteAction extends Action
{

//    public $pk = 'id';

    /**
     * @inheritDoc
     */
    public function init()
    {
        if (!ArrayHelper::getValue($this->messages, 'success')) {
            $this->messages['success'] = function () {
                return Yii::t('codexten:yii:web', '{modelClass} deleted successfully',
                    ['modelClass' => Inflector::singularize(Inflector::camel2words(StringHelper::basename($this->modelClass)))]);
            };
        }
        parent::init();
    }

    /**
     * @param mixed $id
     *
     * @return void|\yii\web\Response
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

        $this->setFlash($this->getSuccessMessage(), ['model' => $model]);

        return $this->controller->redirect(Yii::$app->request->referrer);
    }

//    /**
//     * @param mixed $id
//     *
//     * @return void|\yii\web\Response
//     * @throws \yii\db\Exception
//     */
//    public function run($id)
//    {
//        $modelClass = $this->modelClass;
//        $transaction = Yii::$app->db->beginTransaction();
//        $flag = true;
//
//        if (!$id) {
//            $id = post('selection');
//            if (empty($id)) {
//                $flag = false;
//                Yii::$app->session->setFlash('error', \Yii::t('codexten:yii:web',
//                        'Cannot Delete - No ' . StringHelper::basename($modelClass)) . ' Selected!');
//            }
//        }
//
////        try {
////
////            foreach ($modelClass::findAll([$this->pk => $id]) as $model) {
////                if (is_callable($this->canDelete)) {
////                    $flag = $flag && call_user_func($this->canDelete, $model);
////                }
////                $flag = $flag && $model->delete();
////            }
////
////            if ($flag) {
////                $transaction->commit();
////                Yii::$app->session->setFlash('success', \Yii::t('codexten:yii:web', $this->successMessage ?:
////                    Inflector::camel2words(StringHelper::basename($modelClass)) . ' Deleted Successfully !'));
////            } else {
////                $transaction->rollBack();
////                Yii::$app->session->setFlash('error', \Yii::t('codexten:yii:web', $this->errorMessage ?:
////                    Inflector::camel2words(StringHelper::basename($modelClass)) . ' ' . 'cannot be deleted'));
////            }
////        } catch (IntegrityException $e) {
////            $transaction->rollBack();
////            Yii::$app->session->setFlash('error', \Yii::t('codexten:yii:web', $this->errorMessage ?:
////                Inflector::camel2words(StringHelper::basename($modelClass)) . ' ' . 'cannot be deleted'));
////        }
//
//        return $this->controller->redirect(Yii::$app->request->referrer);
//    }
}
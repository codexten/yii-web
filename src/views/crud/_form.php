<?php

use codexten\gnt\admin\modules\user\models\MemberUser;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model MemberUser */
?>

<?php $form = ActiveForm::begin() ?>

<?= $this->render('form/_fields', compact(['form', 'model'])) ?>

    <div class="form-group">

        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('gnt:core', 'Create') : Yii::t('gnt:core', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

<?php ActiveForm::end() ?>

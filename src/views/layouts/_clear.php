<?php
/**
 * @link https://entero.co.in/
 * @copyright Copyright (c) 2012 Entero Software Solutions Pvt.Ltd
 * @license https://entero.co.in/license/
 * @author Ashlin A <ashlin@entero.in>
 */

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$bodyOptions = \yii\helpers\ArrayHelper::getValue($this->params, ['body', 'options'], []);
?>
<?php $this->beginPage(); ?>

    <!DOCTYPE html>
    <!--[if IE 8]>
    <html lang="<?= Yii::$app->language ?>" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]>
    <html lang="<?= Yii::$app->language ?>" class="ie9 no-js"> <![endif]-->
    <!--[if !IE]><!-->
    <html lang="<?= Yii::$app->language ?>">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>

        <title><?= Html::encode($this->title) ?></title>

        <link rel="shortcut icon" href="<?= Yii::$app->params['favicon'] ?>"/>

        <?= Html::csrfMetaTags() ?>

        <?php $this->head() ?>

    </head>

    <?= Html::beginTag('body', $bodyOptions) ?>

    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>

    <?= Html::endTag('body') ?>

    </html>

<?php $this->endPage() ?>
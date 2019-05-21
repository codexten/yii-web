<?php

use codexten\yii\web\controllers\SiteController;
use codexten\yii\web\ThemeManager;
use codexten\yii\web\UrlManager;
use codexten\yii\web\User;
use codexten\yii\web\widgets\grid\GridView;
use yii\i18n\I18N;
use yii\i18n\PhpMessageSource;

return array_filter([
    'bootstrap' => array_filter([
        'debug' => empty($params['debug.enabled']) ? null : 'debug',
        'themeManager' => 'themeManager',
    ]),
    'runtimePath' => '@root/runtime/frontend',
    'controllerNamespace' => 'codexten\yii\web\controllers',
    'controllerMap' => [
        'site' => [
            'class' => SiteController::class,
        ],
    ],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
        ],
        'request' => [
            'enableCsrfCookie' => true, /// XXX TO BE DISABLED
            'cookieValidationKey' => $params['cookieValidationKey'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => \yii\web\UrlManager::class,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [

            ],
        ],
        'i18n' => [
            'class' => I18N::class,
            'translations' => [
                'entero:web' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@codexten/yii/web/messages',
                ],
            ],
        ],
        'view' => [
            'class' => '\codexten\yii\web\components\View',
            'theme' => [
                'pathMap' => [
                    '@app/views' => [
                        '@codexten/yii/web/views',
                    ],
                    '@app/widgets/views' => [
                        '@codexten/yii/web/widgets/views',
                    ],
                    '@app/widgets/grid' => [
                        '@codexten/yii/web/widgets/grid',
                    ],
                ],
            ],
        ],
        'user' => [
            'class' => User::class,
            'identityClass' => \entero\module\user\models\User::class,
        ],
        'themeManager' => [
            'class' => ThemeManager::class,
        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
    ],
    'container' => [
        'definitions' => [
            \yii\web\UrlManager::class => [
                'class' => UrlManager::class,
            ],
            \yii\web\User::class => [
                'class' => User::class,
            ],
            \yii\grid\GridView::class => [
                'class' => GridView::class,
            ],
        ],
    ],
]);

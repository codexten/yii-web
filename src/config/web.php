<?php

return array_filter([
    'bootstrap' => array_filter([
        'debug' => empty($params['debug.enabled']) ? null : 'debug',
        'themeManager' => 'themeManager',
    ]),
    'runtimePath' => '@root/runtime/frontend',
    'controllerNamespace' => 'codexten\yii\web\controllers',
    'controllerMap' => [
        'site' => [
            'class' => \codexten\yii\web\controllers\SiteController::class,
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
            'class' => \yii\i18n\I18N::class,
            'translations' => [
                'entero:web' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
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
                ],
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'user' => [
            'class' => \codexten\yii\web\User::class,
            'identityClass' => \entero\module\user\models\User::class,
        ],
        'themeManager' => [
            'class' => \codexten\yii\web\ThemeManager::class,
        ],
    ],
    'container' => [
        'definitions' => [
            \yii\web\UrlManager::class => [
                'class' => \codexten\yii\web\UrlManager::class,
            ],
            \yii\web\User::class => [
                'class' => \codexten\yii\web\User::class,
            ],
        ],
    ],
]);

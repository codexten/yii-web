<?php

use codexten\yii\web\components\View;
use codexten\yii\web\controllers\SiteController;
use codexten\yii\web\ThemeManager;
use codexten\yii\web\UrlManager;
use codexten\yii\web\User;
use codexten\yii\web\widgets\grid\GridView;
use yii\i18n\I18N;
use yii\i18n\PhpMessageSource;
use yii\widgets\LinkPager;

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
            'enableMinify' => $params['html.minify'],
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'webPath' => '@web', // path alias to web base
            'basePath' => '@webroot', // path alias to web base
            'minifyPath' => '@webroot/minify', // path alias to save minify result
            'jsPosition' => [\yii\web\View::POS_END], // positions of js files to be minified
            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports' => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
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
            LinkPager::class => [
                'class' => LinkPager::class,
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
            ],
        ],
    ],
]);

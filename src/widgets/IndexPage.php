<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 8/10/18
 * Time: 2:30 PM
 */

namespace codexten\yii\web\widgets;

class IndexPage extends Page
{
    /**
     * @var array
     */
    public $gridConfig = [];

    /**
     * {@inheritdoc}
     */
    protected function defaultConfig()
    {
        $config = parent::defaultConfig();
        $config['actions'] = [
            'create' => [
                'label' => \Yii::t('entero:web', '{icon} Create', ['icon' => '<i class="fa fa-fw fa-plus"></i>']),
                'url' => ['create'],
                'options' => ['class' => 'btn'],
            ],
        ];

        return $config;
    }
}
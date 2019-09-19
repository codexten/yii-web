<?php

namespace codexten\yii\web\widgets;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $areYouSure = true;
    public $fieldConfig = [
        'inputOptions' => ['class' => 'form-control input-sm'],
    ];

    public function init()
    {
        $this->fieldClass = 'codexten\yii\web\widgets\ActiveField';
        $this->registerScript();
        parent::init();
    }

    public function registerScript()
    {
        if ($this->areYouSure == true) {
            $this->view->registerJs("$('#{$this->id}').areYouSure({change: function() {
             $('.disable-on-form-change').addClass('disabled');
            }});");

        }
    }

}

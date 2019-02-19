<?php
namespace codexten\yii\web\widgets\PlacePicker;

use yii\widgets\InputWidget;
use enyii\helpers\Html;
use enyii\helpers\Json;
use enyii\helpers\ArrayHelper;

/*
 * this widget can be used when a user have to tel his location details,
 * this widget will display the google map and it provides search place option
 */

class PlacePicker extends InputWidget
{
    /*
     * @var string , variable to store the id of latitude input field
     */
    public $latitudeFieldId;
    /*
     * @var string , variable to store the id of longitude input field
     */
    public $longitudeFieldId;
    /*
     * @var string , variable to store the name of map canvas input field
     */
    public $name;
    /*
     * array, which binds all client options in to single array
     */
    public $clientOptions = [];
    /*
     * @var num, this variable is used to generate random number
     *  which can be used for generating unique place search field
     */
    public $randNumber;

    public function init()
    {
        MapAsset::register($this->view);
        parent::init();
        $randNumber = rand(1, 100);
        $this->clientOptions = ArrayHelper::merge(
            [
                'latitudeFieldId' => $this->latitudeFieldId,
                'longitudeFieldId' => $this->longitudeFieldId,
                'mapName' => $this->name,
                'searchTextField' => 'searchTextField' . $randNumber

            ],
            $this->clientOptions
        );
        $options = Json::encode($this->clientOptions);
        $this->getView()->registerJs("jQuery('#{$this->getId()}').yiiMapKit({$options});");

    }

    public function run()
    {
        echo Html::tag('br');
        echo Html::textInput('Address', '',
            ['id' => $this->clientOptions['searchTextField'], 'class' => 'form-control']);
        echo Html::tag('br');
        echo Html::beginTag('div', [
            'id' => $this->clientOptions['mapName'],
            'style' => 'height: 450px;width: 100%;margin: 0.6em;'
        ]);
        echo Html::endTag('div');

    }


}

?>
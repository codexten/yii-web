<?php

namespace codexten\yii\web\widgets\SocialProfile;

use enyii\base\Widget;
use enyii\helpers\ArrayHelper;
use enyii\helpers\Html;
use yii\bootstrap\Nav;

class SocialProfile extends Widget
{
    const TEMPLATE_A_TAG = 'a-tag';
    const TEMPLATE_UL_LI = 'ul-li';
    const TEMPLATE_ANIMATED = 'animated';

    /*
    * @var array list of social medias.
    */
    private $_items = [
        'facebook' => ['icon' => 'icon-facebook'],
        'gmail' => ['icon' => 'icon-gmail'],
        'google' => ['icon' => 'icon-gplus'],
        'twitter' => ['icon' => 'icon-twitter'],
        'skype' => ['icon' => 'icon-skype'],
        'flickr' => ['icon' => 'icon-flickr'],
        'youtube' => ['icon' => 'icon-play'],
        'pinterest' => ['icon' => 'icon-pinterest'],
        'linkedin' => ['icon' => 'icon-linkedin'],
        'vimeo' => ['icon' => 'icon-vimeo'],
        'dribbble' => ['icon' => 'icon-dribbble'],
    ];

    /*
    * @var array list of items. list of social medias specified by user
     *
     * - <item-name> => <values>
     * - <item-name> : name of social media item , possible values are listed in $_items array
     * - <values> : required,
     *      - icon: string, optional , the social media  item icon class.
     *      - url: required, the item's URL.
     *      - options : config for <li> tag
     *      - linkOptions : config for <a> tag
     *      - If its value is a string then it will be considered as url
     *
    */
    public $items = [];

    /*
    * @var array list of options.
     *
     * If template is 'ul-li' then this options will be applied to <ul> tag
     * If template is 'animated' or 'a-tag' then applies options to <a> tag
    */
    public $options = [];

    /*
    * @var string.
     * It specifies the tag which  is used in design\
     *
     * -'ul-li' : combination of <ul> and <li> tags
     * -'a-tag' : list of a tag
     * -'animated' : combination <a> and <span> tag with animation
    */
    public $template;

    /*
     * @var array , configurations required for Nav widget
     */
    public $config = [];

    /*
     * @var boolean,set its value to true if icon is circled
     */
    public $iconCircled = false;

    public function init()
    {
        parent::init();

        $this->normalize();
    }

    protected function normalize()
    {
        $items = [];
        foreach ($this->items as $key => $value) {
            if (!isset($this->_items[$key])) {
                continue;
            }

            $url = false;
            $icon = false;
            if (is_array($value)) {
                $url = ArrayHelper::getValue($value, 'url', false);
                $icon = ArrayHelper::getValue($value, 'icon', false);
            } else {
                if (is_string($value)) {
                    $url = $value;
                    $value = ['url' => $url];
                }
            }

            if (!$url || empty($url)) {
                continue;
            }

            if (!$icon || empty($icon)) {
                $icon = $this->_items[$key]['icon'];
                $icon .= $this->iconCircled ? '-circled' : '';
            }

            //setting label
            $value['label'] = Html::tag('i', '', ['class' => $icon]);

            //setting link options
            $linkOptions[] = ArrayHelper::getValue($value, 'linkOptions', false);
            $value['linkOptions'] = ArrayHelper::merge(['title' => ucfirst($key)], $linkOptions);

            $items[$key] = ArrayHelper::merge($this->_items[$key], $value);
        }
        $this->items = $items;
    }

    public function run()
    {
        //setting config array, which is the parameter for Nav widget
        $config = $this->config;
        $config['encodeLabels'] = false;
        $config['items'] = $this->items;

        //generate output according to template
        $template = $this->template;
        if (!isset($template) || ($template == self::TEMPLATE_UL_LI)) {
            $this->getView()->registerJs("$('ul').each(function(){ $(this).removeClass('nav');});");
            $config['options'] = $this->options;

            return Nav::widget($config);
        } elseif ($template == self::TEMPLATE_A_TAG) {
            foreach ($config['items'] as $item) {
                $options = ArrayHelper::merge(['href' => $item['url']], $this->options);
                echo Html::tag('a', $item['label'], $options);
            }
        } elseif ($template == self::TEMPLATE_ANIMATED) {
            foreach ($config['items'] as $name => $item) {
                $class = ArrayHelper::getValue($this->options, 'class', false);

                echo Html::beginTag('a',
                    ['href' => $item['url'], 'class' => 'icon_bar icon_bar_' . $name . ' ' . $class]);
                echo Html::tag('span', $item['label'], ['class' => 't']);
                echo Html::tag('span', $item['label'], ['class' => 'b']);
                echo Html::endTag('a');
            }
        }
    }
}
<?php

namespace frontend\widgets\multiString;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class MultiStringWidget extends InputWidget
{
    /** @var  callable|array */
    public $inputOptions = [];

    /** @var  callable|array */
    public $itemOptions = [];

    /** @var array */
    public $clientOptions = [];

    /** @var array|callable */
    public $addLinkOptions = [];

    /** @var array */
    public $listOptions = [];

    /** @var array */
    public $externalData = [];

    public function init()
    {
        parent::init();

        if (isset($this->options['id']) && !$this->getId(false)) {
            $this->setId($this->options['id']);
        } else {
            $this->options['id'] = $this->getId();
        }

        $idPostfix = '-' . $this->options['id'];

        $this->clientOptions['listClass']    = 'items-list' . $idPostfix;
        $this->clientOptions['addLinkClass'] = 'add-link' . $idPostfix;
        $this->clientOptions['itemClass']    = 'list-item' . $idPostfix;
        $this->clientOptions['removeClass']  = 'remove-item' . $idPostfix;

        Html::addCssClass($this->listOptions, $this->clientOptions['listClass']);

        MultiStringAsset::register($this->view);
    }

    public function listClass()
    {
        return $this->clientOptions['listClass'];
    }

    public function addLinkClass()
    {
        return $this->clientOptions['addLinkClass'];
    }

    public function itemClass()
    {
        return $this->clientOptions['itemClass'];
    }

    public function removeClass()
    {
        return $this->clientOptions['removeClass'];
    }

    public function run()
    {
        parent::run();

        echo Html::beginTag($tag = ArrayHelper::remove($this->options, 'tag', 'div'), $this->options);

        echo Html::beginTag($listTag = ArrayHelper::remove($this->listOptions, 'tag', 'div'), $this->listOptions);

        if ($values = $this->hasModel() ? $this->model->{$this->attribute} : $this->value) {

            foreach ($values as $key => $value) {

                echo $this->renderItem($key, $value);
            }
        } else {
            echo $this->renderItem(null, null);
        }

        echo Html::endTag($listTag);

        if (is_callable($this->addLinkOptions)) {
            echo call_user_func($this->addLinkOptions, $this->renderItem(null, null), $this);
        } else {

            Html::addCssClass($this->addLinkOptions, $this->addLinkClass());

            $this->addLinkOptions['data-sample-item'] = $this->renderItem(null, null);

            echo Html::a(
                Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']) . \Yii::t('common', 'Add...'),
                '#',
                $this->addLinkOptions
            );
        }

        echo Html::endTag($tag);

        $this->view->registerJs('jQuery(\'#' . $this->getId() . '\').multiString(' . Json::encode($this->clientOptions) . ')');
    }

    protected function renderItem($key, $value)
    {
        if (is_callable($this->itemOptions)) {
            return call_user_func($this->itemOptions, $this->renderInput($key, $value), $this);
        }
        Html::addCssClass($this->itemOptions, $this->itemClass());
        return Html::tag(
            ArrayHelper::remove($this->itemOptions, 'tag', 'div'),
            implode(PHP_EOL, [
                $this->renderInput($key, $value),
                Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), '#', ['class' => $this->removeClass()]),
            ]),
            $this->itemOptions
        );
    }

    protected function renderInput($key, $value)
    {
        if (is_callable($this->inputOptions)) {
            return call_user_func($this->inputOptions, $key, $value, $this);
        }
        if ($this->hasModel()) {
            return Html::activeTextInput($this->model, $this->attribute . '[' . $key . ']', $this->inputOptions);
        }
        return Html::textInput($this->name . '[' . $key . ']', $value, $this->inputOptions);
    }
}
<?php
namespace dowlatow\widgets;

use yii\bootstrap\BootstrapThemeAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MultiStringAsset extends AssetBundle
{
    public $js = [
        'js' . DIRECTORY_SEPARATOR . 'multistring.js',
    ];

    public function init()
    {
        parent::init();

        $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'source';
        $this->depends[]  = JqueryAsset::className();
        $this->depends[]  = BootstrapThemeAsset::className();
    }
}
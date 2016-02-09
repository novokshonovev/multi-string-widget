<?php

namespace frontend\widgets\multiString;

use yii\bootstrap\BootstrapThemeAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MultiStringAsset extends AssetBundle
{
    public $js = [
        'multistring.js',
    ];

    public function init()
    {
        parent::init();

        $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'assets';
        $this->depends[] = JqueryAsset::className();
        $this->depends[] = BootstrapThemeAsset::className();
    }
}
<?php


namespace diandi\addons;

use Yii;
use yii\helpers\Inflector;


class Module extends \yii\base\Module
{
    public $controllerNamespace = '@diandi\addons\controllers';

    public $defaultRoute = 'addons';

    public function init()
    {
        parent::init();
    }
}

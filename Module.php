<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-31 13:29:52
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-31 13:29:52
 */



namespace diandi\addons;

use Yii;
use yii\helpers\Inflector;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'diandi\addons\controllers';

    public $defaultRoute = 'addons';

    public function init()
    {
        parent::init();
        if (!isset(Yii::$app->i18n->translations['rbac-admin'])) {
            Yii::$app->i18n->translations['rbac-admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@diandi/admin/messages',
            ];
        }
    }
}

<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:09:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-08-22 00:01:56
 */


namespace diandi\addons\controllers;

use backend\controllers\BaseController;
use Yii;
use diandi\addons\modules\DdAddons;
use diandi\addons\modules\searchs\DdAddons as DdAddonsSearch;
use diandi\addons\services\addonsService;
use diandi\admin\models\Route;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ManageController  extends BaseController
{
    /**
     * 安装
     *
     * @return void
     */
    public function actionInstall()
    {
        $addon = Yii::$app->request->get('addon', '');
        $addonsXml = addonsService::unAddon($addon);
        $res = addonsService::install($addonsXml);
        if ($res) {
   
            return $this->redirect(['addons/index']);
        }
    }

    /**
     * 更新
     *
     * @return void
     */
    public function actionUpdate()
    {
    }

    /**
     * 卸载
     *
     * @return void
     */
    public function actionUninstall()
    {
        $addon = Yii::$app->request->get('addon', '');
        $res = addonsService::unInstall($addon);
        if ($res) {
            return $this->redirect(['addons/index']);
        }
        
    }

    public function actionAuth(){
        
        $Route = new Route();
        $routes = $Route->getAppRoutes('diandi_dingzuo');
        $model = new Route();
        $model->addNew($routes);
        die;
    }
}

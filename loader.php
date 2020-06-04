<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 12:59:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-04 20:35:54
 */

namespace diandi\addons;

use Yii;
use common\helpers\StringHelper;
use diandi\addons\modules\searchs\DdAddons;
use yii\base\BootstrapInterface;
use yii\web\UnauthorizedHttpException;

class Loader implements BootstrapInterface
{
    /**
     * 应用ID.
     *
     * @var
     */
    protected $id;

    /**
     * @param \yii\base\Application $application
     *
     * @throws UnauthorizedHttpException
     * @throws \Exception
     */
    public function bootstrap($application)
    {
        global $_W,$_GPC;
        $_W = Yii::$app->params;
        $_GPC = array_merge(Yii::$app->request->get(),Yii::$app->request->post()); 
        $this->id = Yii::$app->id;
        // 全局获取
        $bloc_id = Yii::$app->request->headers->get('bloc_id', 0);

        $store_id = Yii::$app->request->headers->get('store_id', 0);
        $addons = Yii::$app->request->headers->get('addons', '');
        if (empty($bloc_id)) {
            $bloc_id = Yii::$app->request->get('bloc_id', 0);
        }
        if (empty($store_id)) {
            $store_id = Yii::$app->request->get('store_id', 0);
        }

        if (empty($addons)) {
            $addons = Yii::$app->request->get('addons', '');
        }
        $this->afreshLoad($bloc_id, $store_id, $addons);
    }

    /**
     * 重载配置.
     *
     * @param $merchant_id
     *
     * @throws UnauthorizedHttpException
     */
    public function afreshLoad($bloc_id, $store_id, $addons)
    {
        try {
            Yii::$app->service->commonGlobalsService->initId($bloc_id, $store_id, $addons);
            Yii::$app->service->commonGlobalsService->getConf($bloc_id);
            // 初始化模块
            Yii::$app->setModules($this->getModulesByAddons());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 获取模块.
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function getModulesByAddons()
    {
        $DdAddons = new DdAddons();
        $addons = $DdAddons->find()->asArray()->all();
        $app_id = $this->id;
        switch ($app_id) {
            case 'app-backend':
                $moduleFile = 'site';
                break;
            case 'app-api':
                $moduleFile = 'api';
                break;
            case 'app-frontend':
                $moduleFile = 'frontend';
                break;
            default:
        }
        $modules = [];
        foreach ($addons as $addon) {
            $name = $addon['identifie'];
            $configPath = Yii::getAlias('@common/addons/'.$name.'/config/api.php');
            if (file_exists($configPath)) {
                $config = require $configPath;
                if (!empty($config)) {
                    Yii::$app->getUrlManager()->addRules($config);
                }
            }

            $modules[StringHelper::toUnderScore($name)] = [
                'class' => "common\addons\\".$name.'\\'.$moduleFile,
            ];
        }
        return $modules;
    }
}

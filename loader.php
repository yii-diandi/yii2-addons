<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 12:59:45
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-04-05 13:19:11
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
     * 应用ID
     *
     * @var
     */
    protected $id;


    /**
     * @param \yii\base\Application $application
     * @throws UnauthorizedHttpException
     * @throws \Exception
     */
    public function bootstrap($application)
    {
        $this->id =  Yii::$app->id;
        // 全局获取
        $merchantId = Yii::$app->request->get('merchantId', '');
        $this->afreshLoad($merchantId);
    }

    /**
     * 重载配置
     *
     * @param $merchant_id
     * @throws UnauthorizedHttpException
     */
    public function afreshLoad($merchantId)
    {
        try {
            Yii::$app->service->commonGlobalsService->setMerchanId($merchantId);
            // 初始化模块
            Yii::$app->setModules($this->getModulesByAddons());
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 获取模块
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
            $configPath = Yii::getAlias("@common/addons/" . $name . '/config/api.php');
            if (file_exists($configPath)) {
                $config = require($configPath);
                if (!empty($config)) {
                    Yii::$app->getUrlManager()->addRules($config);
                }
            }

            $modules[StringHelper::toUnderScore($name)] = [
                'class' => "common\addons\\" . $name . "\\" . $moduleFile
            ];
        }


        return $modules;
    }
}

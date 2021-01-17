<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 12:59:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:10:34
 */

namespace diandi\addons;

use Yii;
use common\helpers\StringHelper;
use diandi\addons\models\searchs\DdAddons;
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
        $this->id = Yii::$app->id;
        if (Yii::$app->id == 'app-console') {
            // 迁移不执行相关的全局方法
            $argvStr = implode(',', $_SERVER['argv']);
            $argvs = $this->getArgv($_SERVER['argv']);
            if (strpos($argvStr, 'migrate') == false) {
                $this->afreshLoad($argvs['-bloc_id'], $argvs['-store_id'],$argvs['-addons']);
            }
        } else {
            $_GPC = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
            
            // 全局获取 优先从头部获取
            $bloc_id = Yii::$app->request->headers->get('bloc-id', 0);

            $store_id = Yii::$app->request->headers->get('store-id', 0);

            $access_token = Yii::$app->request->headers->get('access-token', 0);
           
            $addons = Yii::$app->request->headers->get('addons', '');

            if (empty($access_token)) {
                $access_token = isset($_GPC['access-token']) ? $_GPC['access-token'] : 0; 
                // Yii::$app->request->get('bloc_id', 0);
            }
            if (empty($bloc_id)) {
                $bloc_id = isset($_GPC['bloc_id']) ? $_GPC['bloc_id'] : 0; 
                // Yii::$app->request->get('bloc_id', 0);
            }
            if (empty($store_id)) {
                $store_id = isset($_GPC['store_id']) ? $_GPC['store_id'] : 0;
                //Yii::$app->request->get('store_id', 0);
            }

            $_GPC['bloc_id']  = $bloc_id;
            $_GPC['store_id'] = $store_id;
            
            if (empty($addons)) {
                $addons = Yii::$app->request->get('addons', '');
            }
            
            if (Yii::$app->id == 'app-api'){
                $response = Yii::$app->response;
                if (Yii::$app->request->getMethod() == 'OPTIONS') {
                    $response->data = 'options请求 快速响应';
                    $response->statusCode = 200;
                    $response->send();
                    Yii::$app->end();
                    die;
                }
            }
          
            
            Yii::$app->service->commonMemberService->setAccessToken($access_token);

            $this->afreshLoad($bloc_id, $store_id, $addons);
        }
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
            $moduleFile = 'api';
        }

        $modules = [];
        $extendMethod = 'OPTIONS,';
        $extraPatterns = [];
        foreach ($addons as $addon) {
            $name = $addon['identifie'];
            $configPath = Yii::getAlias('@addons/'.$name.'/config/api.php');
            if (file_exists($configPath)) {
                $config = require $configPath;
                if (!empty($config)) {
                    foreach ($config as $key => &$value) {
                        if(is_array($value['extraPatterns']) && !empty($value['extraPatterns'])){
                            foreach ($value['extraPatterns'] as $k => $val) {
                                $newK = !(strpos($k,'OPTIONS') === false)?$k:$extendMethod.$k;
                                $extraPatterns[$newK] = $val;    
                            }
                            $value['extraPatterns'] = $extraPatterns;
                        }
                    }
                    Yii::$app->getUrlManager()->addRules($config);
                }
            }

            $modules[StringHelper::toUnderScore($name)] = [
                'class' => "addons\\".$name.'\\'.$moduleFile,
            ];
        }

        return $modules;
    }

    public function getArgv($argv)
    {
        $list = [];
        foreach ($argv as $key => $value) {
            list($k,$v) = explode('=',$value);
            if(!empty($v) && strpos($k,'-') !== false){
                $list[$k] = $v;                  
            }
        }
        
        return $list;
    }
}

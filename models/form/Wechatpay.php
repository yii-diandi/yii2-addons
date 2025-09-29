<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-14 01:25:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-31 14:08:45
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfWechatpay;
use diandi\addons\services\addonsService;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class Wechatpay extends Model
{
    public $is_showall = false;

    public $id;
    public $bloc_id;
    public $mch_id;
    public $app_id;
    public $notify_url;
    public $key;
    public $server_signkey;
    public $is_server;
    public $server_mchid;

    public $apiclient_cert;
    public $apiclient_key;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'mch_id',
                'app_id',
                'key',
                'notify_url',
                'server_mchid',
                'server_signkey',

            ], 'string'],
            [['apiclient_cert', 'apiclient_key'], 'safe'],
            [['id', 'bloc_id', 'is_server'], 'integer'],
        ];
    }

    public function getConf($bloc_id,$pem=true)
    {
        $conf = new BlocConfWechatpay();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if (!empty($bloc)) {
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            $this->mch_id = $this->decodeConf($bloc['mch_id']);
            $this->app_id = $this->decodeConf($bloc['app_id']);
            $this->server_mchid = $this->decodeConf($bloc['server_mchid']);
            $this->server_signkey = $this->decodeConf($bloc['server_signkey']);
            $this->key = $this->decodeConf($bloc['key']);
            $this->is_server = $bloc['is_server'];
            if ($pem){
                $this->apiclient_cert = $bloc['apiclient_cert']? $bloc['apiclient_cert']:'';
                $this->apiclient_key = $bloc['apiclient_key']? $bloc['apiclient_key']:'';
            }else{
                $this->apiclient_cert = $bloc['apiclient_cert'] && file_exists($bloc['apiclient_cert'])? file_get_contents($bloc['apiclient_cert']):'';
                $this->apiclient_key = $bloc['apiclient_key'] && file_exists($bloc['apiclient_key'])? file_get_contents($bloc['apiclient_key']):'';
            }
            $this->notify_url = $this->decodeConf($bloc['notify_url']);
            return $this;
        }else{
            return [];
        }
    }

    public function decodeConf($data)
    {
        $decodeKey = Yii::$app->params['encryptKey'];
        if (!empty($data)) {
            $val = Yii::$app->getSecurity()->decryptByKey(base64_decode($data), $decodeKey);
            return $this->is_showall ? $val : addonsService::hideStr($val, 2, 5, 1);
        } else {
            return '';
        }
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }
        $BlocConfWechatpay = new BlocConfWechatpay([
            'scenario'=>'update'
        ]);
        $conf = $BlocConfWechatpay::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfWechatpay([
                'scenario'=> 'create'
            ]);
            $conf->setScenario('create');
        }else{
            $conf->setScenario('update');
        }

        $conf->bloc_id = $bloc_id;
        $conf->mch_id = $this->mch_id;
        $conf->server_mchid = $this->server_mchid;
        $conf->server_signkey = $this->server_signkey;
        $conf->is_server = $this->is_server;
        $conf->notify_url = $this->notify_url;
        $conf->key = $this->key;
        $conf->app_id = $this->app_id;

        /**
         * 将内容存储为pem文件
         */
        $apiclient_cert_file = Yii::getAlias('@attachment/wechatpay/'.$bloc_id.'/apiclient_cert.pem');
        $apiclient_key_file = Yii::getAlias('@attachment/wechatpay/'.$bloc_id.'/apiclient_key.pem');
        FileHelper::createDirectory(Yii::getAlias('@attachment/wechatpay/'.$bloc_id));
        file_put_contents($apiclient_cert_file, $this->apiclient_cert);
        file_put_contents($apiclient_key_file, $this->apiclient_key);
        $conf->apiclient_cert = $apiclient_cert_file;
        $conf->apiclient_key  = $apiclient_key_file;

        if ($conf->save()) {
            return [
                'code' => 200,
                'message' => '保存成功'
            ];
        } else {
            $msg = ErrorsHelper::getModelError($conf);
            return [
                'code' => 400,
                'message' => $msg
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'mch_id' => '支付商户号',
            'key' => '秘钥',
            'is_server' => '是否开启服务商',
            'server_mchid' => '服务商商户号',
            'server_signkey' => '服务商秘钥',
        ];
    }
}

<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:04:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:29:06
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\BlocConfApp;
use diandi\addons\models\BlocConfMicroapp;
use diandi\addons\models\BlocConfWxapp;
use diandi\addons\services\addonsService;
use Yii;
use yii\base\Model;

class App extends Model
{
    public $is_showall = false;
    public $id;

    public $bloc_id;
    /**
     * @var string application name
     */
    public $android_ver;
    public $android_url;
    public $ios_ver;
    public $ios_url;
    public $partner;
    public $partner_key;
    public $paysignkey;
    public $app_id;
    public $app_secret;
    public $supports_multiple_countries;
    public $is_registration_open;
    public $privacy_policy;
    public $user_agreement;
    public $privacy_policy_url;
    public $user_agreement_url;
    public $version_desc;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'android_ver',
                'android_url',
                'ios_ver',
                'ios_url',
                'partner',
                'partner_key',
                'paysignkey',
                'app_id',
                'app_secret',
                'privacy_policy_url',
                'user_agreement_url',
                'privacy_policy',
                'user_agreement',
                'version_desc'
            ], 'string'],
            [['bloc_id', 'is_registration_open', 'supports_multiple_countries'], 'integer'],

        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfApp();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if (!empty($bloc)) {
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            $this->partner = $this->decodeConf($bloc['partner']);
            $this->partner_key = $this->decodeConf($bloc['partner_key']);
            $this->paysignkey = $this->decodeConf($bloc['paysignkey']);
            $this->app_id = $this->decodeConf($bloc['app_id']);
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
            $this->android_ver = $bloc['android_ver'];
            $this->android_url = $bloc['android_url'];
            $this->ios_ver = $bloc['ios_ver'];
            $this->ios_url = $bloc['ios_url'];
            $this->supports_multiple_countries = $bloc['supports_multiple_countries'];
            $this->is_registration_open = $bloc['is_registration_open'];
            $this->privacy_policy = $bloc['privacy_policy'];
            $this->user_agreement = $bloc['user_agreement'];
            $this->privacy_policy_url = $bloc['privacy_policy_url'];
            $this->user_agreement_url = $bloc['user_agreement_url'];
            $this->version_desc = $bloc['version_desc'];

            return $this;
        } else {
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
            return $this->validate();
        }
        $BlocConfApp = new BlocConfApp([
            'scenario' => 'update'
        ]);

        $conf = $BlocConfApp::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfApp([
                'scenario' => 'create'
            ]);
            $conf->setScenario('create');
        } else {
            $conf->setScenario('update');
        }

        $conf->bloc_id = $bloc_id;
        $conf->android_ver = $this->android_ver;
        $conf->android_url = $this->android_url;
        $conf->ios_ver = $this->ios_ver;
        $conf->ios_url = $this->ios_url;
        $conf->partner = $this->partner;
        $conf->partner_key = $this->partner_key;
        $conf->paysignkey = $this->paysignkey;
        $conf->app_id = $this->app_id;
        $conf->app_secret = $this->app_secret;
        $conf->supports_multiple_countries = (int)$this->supports_multiple_countries;
        $conf->is_registration_open = (int)$this->is_registration_open;
        $conf->privacy_policy = $this->privacy_policy;
        $conf->user_agreement = $this->user_agreement;
        $conf->privacy_policy_url = $this->privacy_policy_url;
        $conf->user_agreement_url = $this->user_agreement_url;
        $conf->version_desc = $this->version_desc;


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
            'android_ver' => '安卓版本',
            'android_url' => '安卓最新版地址',
            'ios_ver' => 'ios版本',
            'ios_url' => 'ios最新版地址',
            'partner' => '财付通商户号',
            'partner_key' => '财付通密钥',
            'paysignkey' => '支付签名密钥',
            'app_id' => '微信开放平台app_id',
            'app_secret' => '微信开放平台app_secret'
        ];
    }
}
<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-07-18 16:15:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-29 11:38:37
 */

namespace diandi\addons\models\form;

use diandi\addons\models\BlocConfWechatOpen;
use Yii;
use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfApi;
use diandi\addons\services\addonsService;
use yii\base\Model;

class WechatOpen extends Model
{
    public $is_showall = true;
    public $id;
    public $bloc_id;

    /**
     * @var string application id
     */
    public $app_id;

    /**
     * @var string token
     */
    public $token;

    /**
     * @var string application secret
     */
    public $app_secret;

    /**
     * @var string aes key
     */
    public $aes_key;

    public $pc_appid;

    public $pc_secret;
    public $wechat_login_type;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['app_id', 'token', 'app_secret', 'aes_key','pc_appid','pc_secret'], 'string'],
            [['app_id', 'token', 'app_secret', 'aes_key'], 'required'],
            [['id', 'bloc_id','wechat_login_type'], 'integer'],
        ];
    }

    /**
     * 获取配置信息
     * @param int $bloc_id
     */
    public function getConf($bloc_id)
    {
        $conf = new BlocConfWechatOpen();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if (!empty($bloc)) {
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            $this->app_id = $bloc['app_id'];
            $this->token = $bloc['token'];
            $this->pc_appid = $this->decodeConf($bloc['pc_appid']);
            $this->pc_secret = $this->decodeConf($bloc['pc_secret']);
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
            $this->aes_key = $this->decodeConf($bloc['aes_key']);
        }
    }

    /**
     * 根据 app_id 获取配置信息
     * @param string $appId
     */
    public function getApiConf($appId)
    {
        $conf = new BlocConfWechatOpen();
        $bloc = $conf::find()->where(['app_id' => $appId])->asArray()->one();
        if (!empty($bloc)) {
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            $this->app_id = $bloc['app_id'];
            $this->token = $bloc['token'];
            $this->pc_appid = $this->decodeConf($bloc['pc_appid']);
            $this->pc_secret = $this->decodeConf($bloc['pc_secret']);
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
            $this->aes_key = $this->decodeConf($bloc['aes_key']);
        }
    }

    /**
     * 解密配置数据
     * @param string $data
     * @return string
     */
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

    /**
     * 加密配置数据
     * @param string $data
     * @return string
     */
    public function encodeConf($data)
    {
        $encodeKey = Yii::$app->params['encryptKey'];
        if (!empty($data)) {
            return base64_encode(Yii::$app->getSecurity()->encryptByKey($data, $encodeKey));
        } else {
            return '';
        }
    }

    /**
     * 保存配置信息
     * @param int $bloc_id
     * @return array
     */
    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return [
                'code' => 400,
                'message' => current($this->getFirstErrors()) ?? '未知错误'
            ];
        }

        $BlocConfApi = new BlocConfWechatOpen([
            'scenario' => 'update'
        ]);
        $conf = $BlocConfApi::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfWechatOpen([
                'scenario' => 'create'
            ]);
            $conf->setScenario('create');
        } else {
            $conf->setScenario('update');
        }

        $conf->bloc_id = $bloc_id;
        $conf->app_id = $this->app_id;
        $conf->token = $this->token;
        // 对敏感信息进行加密存储
        $conf->app_secret = $this->app_secret;
        $conf->aes_key = $this->aes_key;
        $conf->pc_appid = $this->pc_appid;
        $conf->pc_secret = $this->pc_secret;
        $conf->wechat_login_type = $this->wechat_login_type;

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
            'app_id' => 'APP ID',
            'token' => 'Token',
            'app_secret' => 'APP SECRET',
            'aes_key' => 'AES Key',
        ];
    }
}

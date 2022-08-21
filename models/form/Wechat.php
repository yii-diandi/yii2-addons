<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:04:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:36:43
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfWechat;
use diandi\addons\services\addonsService;
use Yii;
use yii\base\Model;

class Wechat extends Model
{
    public $is_showall = false;

    public $id;

    public $bloc_id;

    public $app_id;
    public $secret;
    public $token;
    public $aes_key;
    public $headimg;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'app_id',
                'token',
                'secret',
                'aes_key',
                'headimg',
            ], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfWechat();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if(!empty($bloc)){
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            $this->app_id = $this->decodeConf($bloc['app_id']);
            $this->token = $this->decodeConf($bloc['token']);
            $this->aes_key = $this->decodeConf($bloc['aes_key']);
            $this->secret = $this->decodeConf($bloc['secret']);
            $this->headimg = $this->decodeConf($bloc['headimg']);
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

        $conf = BlocConfWechat::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfWechat();
        }
        $conf->bloc_id = $bloc_id;

        $conf->app_id = $this->app_id;
        $conf->token = $this->token;
        $conf->aes_key = $this->aes_key;
        $conf->secret = $this->secret;
        $conf->headimg = $this->headimg;

        if ($conf->save()) {
            return [
                 'code' => 200,
                 'message' => '保存成功',
             ];
        } else {
            $msg = ErrorsHelper::getModelError($conf);

            return [
                'code' => 400,
                'message' => $msg,
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司ID',
            'app_id' => 'app_id',
            'secret' => 'secret',
            'token' => 'token',
            'aes_key' => 'aes_key',
            'update_time' => '更新时间',
            'create_time' => '创建时间',
        ];
    }
}

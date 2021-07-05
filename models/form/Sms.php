<?php

/**
 * @Author: Wang chunsheng  &#60;2192138785@qq.com&#62;
 * @Date:   2020-04-29 17:21:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-05 15:04:57
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfSms;
use yii\base\Model;

class Sms extends Model
{
    public $id;

    public $bloc_id;

    /**
     * @var string application name
     */
    public $access_key_id;

    public $access_key_secret;

    /**
     * @var string admin email
     */
    public $sign_name;

    public $template_code;
    public $is_login;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['access_key_id', 'access_key_secret', 'sign_name'], 'string'],
            ['template_code', 'string'],
            [['id', 'bloc_id', 'is_login'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfSms();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];
        $this->access_key_id = $bloc['access_key_id'];
        $this->access_key_secret = $bloc['access_key_secret'];
        $this->sign_name = $bloc['sign_name'];
        $this->template_code = $bloc['template_code'];
        $this->is_login = $bloc['is_login'];
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = BlocConfSms::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new BlocConfSms();
        }
        $conf->bloc_id = $bloc_id;
        $conf->access_key_id = $this->access_key_id;
        $conf->access_key_secret = $this->access_key_secret;
        $conf->sign_name = $this->sign_name;
        $conf->template_code = $this->template_code;
        $conf->is_login = $this->is_login;

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
            'access_key_id' => 'AccessKey ID',
            'access_key_secret' => 'Access Key Secret',
            'sign_name' => '签名',
            'template_code' => '模板code',
            'is_login' => '是否必须绑定手机号登录'
        ];
    }
}

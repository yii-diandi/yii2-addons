<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:03:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-27 08:24:25
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfOss;
use yii\base\Model;

class Oss extends Model
{
    /**
     * @var string application name
     */
    public $id;
    public $bloc_id;

    public $Aliyunoss_accessKeyId;
    public $Aliyunoss_resource;
    public $Aliyunoss_accessKeySecret;
    public $Aliyunoss_url;
    public $Tengxunoss_APPID;
    public $Tengxunoss_SecretID;
    public $Tengxunoss_SecretKEY;
    public $Tengxunoss_Bucket;
    public $Tengxunoss_area;
    public $Tengxunoss_url;
    public $Qiniuoss_Accesskey;
    public $Qiniuoss_Secretkey;
    public $Qiniuoss_Bucket;
    public $Qiniuoss_url;
    public $remote_type;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['Aliyunoss_accessKeyId',
            'Aliyunoss_resource',
            'Aliyunoss_accessKeySecret',
            'Aliyunoss_url',
            'Tengxunoss_APPID',
            'Tengxunoss_SecretID',
            'Tengxunoss_SecretKEY',
            'Tengxunoss_Bucket',
            'Tengxunoss_area',
            'Tengxunoss_url',
            'Qiniuoss_Accesskey',
            'Qiniuoss_Secretkey',
            'Qiniuoss_Bucket',
            'remote_type',
            'Qiniuoss_url', ], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfOss();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();

        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];

        $this->remote_type = $bloc['remote_type'];
        $this->Aliyunoss_accessKeyId = $bloc['Aliyunoss_accessKeyId'];
        $this->Aliyunoss_resource = $bloc['Aliyunoss_resource'];
        $this->Aliyunoss_accessKeySecret = $bloc['Aliyunoss_accessKeySecret'];
        $this->Aliyunoss_url = $bloc['Aliyunoss_url'];
        $this->Tengxunoss_APPID = $bloc['Tengxunoss_APPID'];
        $this->Tengxunoss_SecretID = $bloc['Tengxunoss_SecretID'];
        $this->Tengxunoss_SecretKEY = $bloc['Tengxunoss_SecretKEY'];
        $this->Tengxunoss_Bucket = $bloc['Tengxunoss_Bucket'];
        $this->Tengxunoss_area = $bloc['Tengxunoss_area'];
        $this->Tengxunoss_url = $bloc['Tengxunoss_url'];
        $this->Qiniuoss_Accesskey = $bloc['Qiniuoss_Accesskey'];
        $this->Qiniuoss_Secretkey = $bloc['Qiniuoss_Secretkey'];
        $this->Qiniuoss_Bucket = $bloc['Qiniuoss_Bucket'];
        $this->Qiniuoss_url = $bloc['Qiniuoss_url'];
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = BlocConfOss::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfOss();
        }

        $conf->bloc_id = $bloc_id;
        $conf->remote_type = $this->remote_type;
        $conf->Aliyunoss_accessKeyId = $this->Aliyunoss_accessKeyId;
        $conf->Aliyunoss_resource = $this->Aliyunoss_resource;
        $conf->Aliyunoss_accessKeySecret = $this->Aliyunoss_accessKeySecret;
        $conf->Aliyunoss_url = $this->Aliyunoss_url;
        $conf->Tengxunoss_APPID = $this->Tengxunoss_APPID;
        $conf->Tengxunoss_SecretID = $this->Tengxunoss_SecretID;
        $conf->Tengxunoss_SecretKEY = $this->Tengxunoss_SecretKEY;
        $conf->Tengxunoss_Bucket = $this->Tengxunoss_Bucket;
        $conf->Tengxunoss_area = $this->Tengxunoss_area;
        $conf->Tengxunoss_url = $this->Tengxunoss_url;
        $conf->Qiniuoss_Accesskey = $this->Qiniuoss_Accesskey;
        $conf->Qiniuoss_Secretkey = $this->Qiniuoss_Secretkey;
        $conf->Qiniuoss_Bucket = $this->Qiniuoss_Bucket;
        $conf->Qiniuoss_url = $this->Qiniuoss_url;

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
            'Aliyunoss_accessKeyId' => 'Aliyunoss_accessKeyId',
            'Aliyunoss_resource' => 'Aliyunoss_resource',
            'Aliyunoss_accessKeySecret' => 'Aliyunoss_accessKeySecret',
            'Aliyunoss_url' => 'Aliyunoss_url',
            'Tengxunoss_APPID' => 'Tengxunoss_APPID',
            'Tengxunoss_SecretID' => 'Tengxunoss_SecretID',
            'Tengxunoss_SecretKEY' => 'Tengxunoss_SecretKEY',
            'Tengxunoss_Bucket' => 'Tengxunoss_Bucket',
            'Tengxunoss_area' => 'Tengxunoss_area',
            'Tengxunoss_url' => 'Tengxunoss_url',
            'Qiniuoss_Accesskey' => 'Qiniuoss_Accesskey',
            'Qiniuoss_Secretkey' => 'Qiniuoss_Secretkey',
            'Qiniuoss_Bucket' => 'Qiniuoss_Bucket',
            'Qiniuoss_url' => 'Qiniuoss_url',
        ];
    }
}
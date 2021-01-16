<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-14 01:25:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:04:31
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfWechatpay;
use yii\base\Model;

class Wechatpay extends Model
{
    /**
     * @var string application name
     */
    public $appId;
    public $id;

    public $bloc_id;
    /**
     * @var string admin email
     */
    public $mch_id;
    public $app_id;
    public $key;

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
            ], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfWechatpay();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();

        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];
        $this->mch_id = $bloc['mch_id'];
        $this->app_id = $bloc['app_id'];
        $this->key = $bloc['key'];
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }
        $conf = BlocConfWechatpay::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfWechatpay();
        }

        $conf->bloc_id = $bloc_id;
        $conf->mch_id = $this->mch_id;
        $conf->app_id = $this->app_id;
        $conf->key = $this->key;

       
        if($conf->save()){
            return [
                'code'=>200,
                'message'=>'保存成功'
            ];
       }else{
           $msg = ErrorsHelper::getModelError($conf);
           return [
               'code'=>400,
               'message'=>$msg
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
            'app_id' => 'AppId',
            'key' => '秘钥',
        ];
    }
}

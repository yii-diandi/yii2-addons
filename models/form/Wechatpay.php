<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-14 01:25:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-01 11:10:02
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
    
    public $id;

    public $bloc_id;
    /**
     * @var string admin email
     */
    public $mch_id;
    
    public $key;
    public $server_signkey;
    public $is_server;
    public $server_mchid;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'mch_id',
                'key',
                'server_mchid',
                'server_signkey'
            ], 'string'],
            [['id', 'bloc_id','is_server'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfWechatpay();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
      
        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];
        $this->mch_id = $bloc['mch_id'];
        $this->server_mchid = $bloc['server_mchid'];
        $this->server_signkey = $bloc['server_signkey'];
        $this->key = $bloc['key'];
        $this->is_server = $bloc['is_server'];
        
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
        $conf->server_mchid = $this->server_mchid;
        $conf->server_signkey = $this->server_signkey;
        $conf->is_server = $this->is_server;
        
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
            'key' => '秘钥',
            'is_server'=> '是否开启服务商',
            'server_mchid'=>'服务商商户号',
            'server_signkey'=>'服务商秘钥',
        ];
    }
}

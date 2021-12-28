<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 22:47:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 09:45:23
 */

namespace diandi\addons\models;

use Yii;


/**
 * This is the model class for table "diandi_bloc_conf_wechatpay".
 *
 * @property int      $id
 * @property int      $bloc_id     公司ID
 * @property string   $mch_id      商户ID
 * @property int      $app_id      APPID
 * @property string   $key         支付密钥
 * @property string   $notify_url  回调地址
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfWechatpay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_wechatpay}}';
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'mch_id'], 'required'],
            [['bloc_id', 'create_time', 'update_time', 'is_server'], 'integer'],
            [['notify_url', 'app_id', 'mch_id','key', 'notify_url',  'server_mchid', 'server_signkey'], 'string', 'max' => 255],
            [['bloc_id'], 'unique']
        ];
    }

     
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $list = array_keys($this->attributes);
            foreach ($list as $key => $value) {
                //$data:需要加密的信息,$secretKey:加密时使用的密钥(key) 
                $secretKey = Yii::$app->params['encryptKey'];
                if(!in_array($value,['id','bloc_id','create_time','update_time'])){
                    $this->$value = Yii::$app->getSecurity()->encryptByKey($this->attributes[$value], $secretKey);                     
                }
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司ID',
            'mch_id' => '商户ID',
            'app_id' => 'APPID',
            'is_server' => '是否开启服务商',
            'server_mchid' => '服务商商户号',
            'server_signkey' => '服务商秘钥',
            'key' => '支付密钥',
            'notify_url' => '回调地址',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}

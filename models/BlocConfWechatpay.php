<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 22:47:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-02-21 14:44:11
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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id','mch_id','app_id','key','notify_url','is_server','server_mchid','server_signkey','apiclient_cert','apiclient_key','create_time','update_time'];
        $scenarios[self::SCENARIO_UPDATE] = ['mch_id','app_id','key','notify_url','is_server','server_mchid','server_signkey','apiclient_cert','apiclient_key','create_time','update_time'];
        return $scenarios;
    }
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
            [['bloc_id'], 'unique'],
            [['apiclient_cert','apiclient_key'],'safe']
        ];
    }

   	
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
                // 新增
                $list = array_keys($this->attributes);
                foreach ($list as $key => $value) {
                    //$data:需要加密的信息,$secretKey:加密时使用的密钥(key) 
                    $secretKey = Yii::$app->params['encryptKey'];
                    if(!in_array($value,['id','bloc_id','create_time','update_time','is_server','apiclient_cert','apiclient_key'])){
                        if(!$this->isNewRecord){ 
                            // 更新的时候必须无星号才处理
                            if($this->attributes[$value] && is_string($this->attributes[$value]) && strpos($this->attributes[$value],'*') === false){
                                $this->$value = base64_encode(Yii::$app->getSecurity()->encryptByKey($this->attributes[$value], $secretKey));
                            }else{
                                // 原来的加密数据过滤不做更新
                                unset($this->$value);
                            }
                        }else{
                            $this->$value = base64_encode(Yii::$app->getSecurity()->encryptByKey($this->attributes[$value], $secretKey));                     
                        }
                           
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

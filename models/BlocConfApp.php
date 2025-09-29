<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-03 23:18:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 15:53:02
 */


namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_bloc_conf_app}}".
 *
 * @property int $id
 * @property int|null $bloc_id
 * @property string|null $android_ver
 * @property string|null $android_url
 * @property string|null $ios_ver
 * @property string|null $ios_url
 * @property string|null $partner
 * @property string|null $partner_key
 * @property string|null $paysignkey
 * @property string|null $app_id
 * @property string|null $app_secret
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfApp extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_app}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id','android_ver', 'android_url', 'ios_ver', 'ios_url', 'partner', 'partner_key', 'paysignkey', 'app_id', 'app_secret','create_time','update_time'];
        $scenarios[self::SCENARIO_UPDATE] = ['android_ver', 'android_url', 'ios_ver', 'ios_url', 'partner', 'partner_key', 'paysignkey', 'app_id', 'app_secret','create_time','update_time'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner', 'partner_key', 'paysignkey', 'app_id', 'app_secret'],'required'],
            [['bloc_id', 'create_time', 'update_time'], 'integer'],
            [['android_ver', 'android_url', 'ios_ver', 'ios_url', 'partner', 'partner_key', 'paysignkey', 'app_id', 'app_secret'], 'string', 'max' => 255],
            [[
                'supports_multiple_countries',
                'is_registration_open',
                'privacy_policy_url',
                'user_agreement_url',
            ], 'string', 'max' => 255],
            [[ 'privacy_policy','user_agreement'],'safe'],
            [['bloc_id'], 'unique']
        ];
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
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
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
                    if(!in_array($value,['bloc_id','android_ver','android_url','ios_ver','ios_url','create_time','update_time','supports_multiple_countries','is_registration_open','privacy_policy','user_agreement','privacy_policy_url','user_agreement_url'
                    ])){
                        if(!$this->isNewRecord){ 
                            // 更新的时候必须无星号才处理
                            if(strpos($this->attributes[$value],'*') === false){
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
            'android_ver' => '安卓版本',
            'android_url' => '下载地址',
            'ios_ver' => 'IOS版本',
            'ios_url' => 'Ios下载地址',
            'partner' => '商户号',
            'partner_key' => '商户密钥',
            'paysignkey' => '支付签名密钥',
            'app_id' => '微信开放平台AppID',
            'app_secret' => '微信开放平台AppSecret',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}

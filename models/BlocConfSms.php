<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 20:18:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 15:57:16
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "diandi_bloc_conf_sms".
 *
 * @property int    $id
 * @property int    $bloc_id
 * @property string $access_key_id
 * @property int    $access_key_secret
 * @property string $sign_name
 * @property string $template_code
 */
class BlocConfSms extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id','access_key_id','access_key_secret','sign_name','template_code','is_login','update_time','create_time'];
        $scenarios[self::SCENARIO_UPDATE] = ['access_key_id','access_key_secret','sign_name','template_code','is_login','update_time','create_time'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_sms}}';
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

  	
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
                // 新增
                $list = array_keys($this->attributes);
                foreach ($list as $key => $value) {
                    //$data:需要加密的信息,$secretKey:加密时使用的密钥(key) 
                    $secretKey = Yii::$app->params['encryptKey'];
                    if(!in_array($value,['id','bloc_id','create_time','update_time'])){
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
    public function rules()
    {
        return [
            [['access_key_id', 'template_code', 'access_key_secret'], 'required'],
            [['bloc_id', 'id', 'is_login'], 'integer'],
            [['template_code','access_key_id','sign_name'], 'string', 'max' => 255],
            [['bloc_id'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => 'Bloc ID',
            'access_key_id' => 'Access Key ID',
            'access_key_secret' => 'Access Key Secret',
            'sign_name' => 'Sign Name',
            'template_code' => 'Template Code',
            'is_login' => '是否必须绑定手机号登录'
        ];
    }
}

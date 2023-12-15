<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-09 16:08:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 15:57:23
 */


namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_bloc_conf_wechat}}".
 *
 * @property int $id
 * @property int|null $bloc_id
 * @property string|null $app_id app_id
 * @property string|null $secret secret
 * @property string|null $token token
 * @property string|null $aes_key aes_key
 * @property string|null $headimg 公众号头像
 * @property int|null $update_time
 * @property int|null $create_time
 */
class BlocConfWechat extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id','app_id','secret','token','aes_key','headimg','update_time','create_time'];
        $scenarios[self::SCENARIO_UPDATE] = ['app_id','secret','token','aes_key','headimg','update_time','create_time'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_wechat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'update_time', 'create_time'], 'integer'],
            [['app_id','secret','token', 'headimg', 'aes_key'], 'string', 'max' => 255],
            [['bloc_id'], 'unique'],
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => 'Bloc ID',
            'app_id' => 'app_id',
            'secret' => 'secret',
            'token' => 'token',
            'aes_key' => 'aes_key',
            'headimg' => '公众号头像',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
}

<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 22:41:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 15:57:37
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "diandi_bloc_conf_wxapp".
 *
 * @property int      $id
 * @property int      $bloc_id
 * @property string   $name        公司名称
 * @property int      $description 上级商户
 * @property string   $original
 * @property string   $AppId       省份
 * @property string   $headimg     城市
 * @property string   $AppSecret   区县
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfWxapp extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id','name','description','original','AppId','headimg','AppSecret','codeUrl','create_time','update_time','share_title','share_path','share_image'];
        $scenarios[self::SCENARIO_UPDATE] = ['name','description','original','AppId','headimg','AppSecret','codeUrl','create_time','update_time','share_title','share_path','share_image'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_wxapp}}';
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
            [['bloc_id', 'name', 'AppId', 'headimg', 'AppSecret'], 'required'],
            [['bloc_id', 'create_time', 'update_time'], 'integer'],
            [['share_title'], 'string', 'max' => 50],
            [['AppId',  'AppSecret','name','original', 'headimg', 'description', 'codeUrl','share_path','share_image'], 'string', 'max' => 255]
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
                    if(!in_array($value,['id','bloc_id','create_time','name','description','update_time','share_title','share_path','share_image', 'codeUrl', 'headimg'])){
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
            'name' => '公司名称',
            'codeUrl' => '普通二维码链接',
            'description' => '小程序简介',
            'original' => 'Original',
            'AppId' => 'AppId',
            'headimg' => '二维码',
            'AppSecret' => 'AppSecret',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}

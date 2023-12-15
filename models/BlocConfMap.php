<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-17 08:48:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 15:56:45
 */
 

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "dd_bloc_conf_map".
 *
 * @property int $id
 * @property int|null $bloc_id
 * @property string|null $baiduApk
 * @property string|null $amapApk
 * @property string|null $tencentApk
 */
class BlocConfMap extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id','baiduApk','amapApk','tencentApk'];
        $scenarios[self::SCENARIO_UPDATE] = ['baiduApk','amapApk','tencentApk'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_map}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id'], 'integer'],
            [['baiduApk', 'amapApk', 'tencentApk'], 'string', 'max' => 255],
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
            'baiduApk' => 'Baidu Apk',
            'amapApk' => 'Amap Apk',
            'tencentApk' => 'Tencent Apk',
        ];
    }
}

<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-17 08:48:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 09:44:57
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
            'bloc_id' => 'Bloc ID',
            'baiduApk' => 'Baidu Apk',
            'amapApk' => 'Amap Apk',
            'tencentApk' => 'Tencent Apk',
        ];
    }
}

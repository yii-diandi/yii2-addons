<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 23:14:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 09:44:48
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "diandi_bloc_conf_baidu".
 *
 * @property int      $id
 * @property int      $bloc_id     公司ID
 * @property string   $APP_ID      APP_ID
 * @property int      $API_KEY     API_KEY
 * @property string   $SECRET_KEY  SECRET_KEY
 * @property string   $name        应用名称
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfBaidu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_baidu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'APP_ID', 'name'], 'required'],
            [['bloc_id', 'create_time', 'update_time'], 'integer'],
            [['name','APP_ID','SECRET_KEY', 'API_KEY'], 'string', 'max' => 255],
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
            'bloc_id' => '公司ID',
            'APP_ID' => 'APP_ID',
            'API_KEY' => 'API_KEY',
            'SECRET_KEY' => 'SECRET_KEY',
            'name' => '应用名称',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}

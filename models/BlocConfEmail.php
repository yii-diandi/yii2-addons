<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 23:12:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 13:24:54
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "diandi_bloc_conf_email".
 *
 * @property int    $id
 * @property int    $bloc_id     公司ID
 * @property string $host
 * @property int    $port
 * @property string $username    邮箱地址
 * @property string $password    邮箱密码
 * @property string $title       发送人
 * @property string $encryption  发送方式
 * @property int    $create_time
 * @property int    $update_time
 */
class BlocConfEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_email}}';
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
            [['bloc_id', 'host', 'password', 'title', 'encryption'], 'required'],
            [['bloc_id', 'port', 'create_time', 'update_time'], 'integer'],
            [['host','username','password', 'title', 'encryption'], 'string', 'max' => 255],
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
                    $this->$value = base64_encode(Yii::$app->getSecurity()->encryptByKey($this->attributes[$value], $secretKey));                     
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
            'host' => 'Host',
            'port' => 'Port',
            'username' => '邮箱地址',
            'password' => '邮箱密码',
            'title' => '发送人',
            'encryption' => '发送方式',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}

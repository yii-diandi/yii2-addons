<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-21 10:51:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 15:57:02
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "dd_bloc_conf_oss".
 *
 * @property int         $id
 * @property int         $bloc_id                   公司ID
 * @property int|null    $Aliyunoss_accessKeyId
 * @property string|null $Aliyunoss_resource
 * @property string|null $Aliyunoss_accessKeySecret
 * @property string|null $Aliyunoss_url
 * @property string|null $Tengxunoss_APPID
 * @property string      $Tengxunoss_SecretID
 * @property string      $Tengxunoss_SecretKEY
 * @property string|null $Tengxunoss_Bucket
 * @property string|null $Tengxunoss_area
 * @property string|null $Tengxunoss_url
 * @property string|null $Qiniuoss_Accesskey
 * @property string|null $Qiniuoss_Secretkey
 * @property string|null $Qiniuoss_Bucket
 * @property string|null $Qiniuoss_url
 * @property string|null $create_time
 * @property string|null $update_time
 */
class BlocConfOss extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_oss}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['Aliyunoss_accessKeyId','remote_type', 'Aliyunoss_resource', 'Aliyunoss_accessKeySecret', 'Aliyunoss_url', 'Tengxunoss_APPID', 'Tengxunoss_SecretID', 'Tengxunoss_SecretKEY', 'Tengxunoss_Bucket', 'Tengxunoss_area', 'Tengxunoss_url', 'Qiniuoss_Accesskey', 'Qiniuoss_Secretkey', 'Qiniuoss_Bucket', 'Qiniuoss_url'], 'string', 'max' => 255],
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
                'time_type' => 'datetime',
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
                    if(!in_array($value,['id','bloc_id','create_time','update_time','remote_type','Aliyunoss_resource'])){
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
            'Aliyunoss_accessKeyId' => 'Aliyunoss Access Key ID',
            'Aliyunoss_resource' => 'Aliyunoss Resource',
            'Aliyunoss_accessKeySecret' => 'Aliyunoss Access Key Secret',
            'Aliyunoss_url' => 'Aliyunoss Url',
            'Tengxunoss_APPID' => 'Tengxunoss  Appid',
            'Tengxunoss_SecretID' => 'Tengxunoss  Secret ID',
            'Tengxunoss_SecretKEY' => 'Tengxunoss  Secret Key',
            'Tengxunoss_Bucket' => 'Tengxunoss  Bucket',
            'Tengxunoss_area' => 'Tengxunoss Area',
            'Tengxunoss_url' => 'Tengxunoss Url',
            'Qiniuoss_Accesskey' => 'Qiniuoss  Accesskey',
            'Qiniuoss_Secretkey' => 'Qiniuoss  Secretkey',
            'Qiniuoss_Bucket' => 'Qiniuoss  Bucket',
            'Qiniuoss_url' => 'Qiniuoss Url',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}

<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-21 10:51:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-26 19:45:37
 */

namespace diandi\addons\models;

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
        return 'dd_bloc_conf_oss';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id','Aliyunoss_resource'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['Aliyunoss_accessKeyId','remote_type','Aliyunoss_bucket', 'Aliyunoss_accessKeySecret', 'Aliyunoss_url', 'Tengxunoss_APPID', 'Tengxunoss_SecretID', 'Tengxunoss_SecretKEY', 'Tengxunoss_Bucket', 'Tengxunoss_area', 'Tengxunoss_url', 'Qiniuoss_Accesskey', 'Qiniuoss_Secretkey', 'Qiniuoss_Bucket', 'Qiniuoss_url'], 'string', 'max' => 100],
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

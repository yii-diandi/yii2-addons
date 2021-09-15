<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 20:18:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-05 15:43:30
 */

namespace diandi\addons\models;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_bloc_conf_sms}}';
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
            [['access_key_id', 'template_code', 'access_key_secret'], 'required'],
            [['bloc_id', 'id', 'is_login'], 'integer'],
            [['access_key_id'], 'string', 'max' => 100],
            [['sign_name'], 'string', 'max' => 255],
            [['template_code'], 'string', 'max' => 15],
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

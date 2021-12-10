<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-09 16:08:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 10:05:34
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
            [['app_id'], 'string', 'max' => 50],
            [['secret'], 'string', 'max' => 200],
            [['token', 'headimg', 'aes_key'], 'string', 'max' => 255],
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

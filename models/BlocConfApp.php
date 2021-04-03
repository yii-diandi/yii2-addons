<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-03 23:18:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-03 23:18:49
 */
 

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_bloc_conf_app}}".
 *
 * @property int $id
 * @property int|null $bloc_id
 * @property string|null $android_ver
 * @property string|null $android_url
 * @property string|null $ios_ver
 * @property string|null $ios_url
 * @property string|null $partner
 * @property string|null $partner_key
 * @property string|null $paysignkey
 * @property string|null $app_id
 * @property string|null $app_secret
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfApp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_bloc_conf_app}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'create_time', 'update_time'], 'integer'],
            [['android_ver', 'android_url', 'ios_ver', 'ios_url', 'partner', 'partner_key', 'paysignkey', 'app_id', 'app_secret'], 'string', 'max' => 255],
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
            'android_ver' => 'Android Ver',
            'android_url' => 'Android Url',
            'ios_ver' => 'Ios Ver',
            'ios_url' => 'Ios Url',
            'partner' => 'Partner',
            'partner_key' => 'Partner Key',
            'paysignkey' => 'Paysignkey',
            'app_id' => 'App ID',
            'app_secret' => 'App Secret',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
